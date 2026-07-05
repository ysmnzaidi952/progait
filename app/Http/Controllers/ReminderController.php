<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reminder;
use App\Models\Patient;
use Carbon\Carbon;
use Twilio\Rest\Client;

class ReminderController extends Controller
{
    public function create()
    {
        $patients = Patient::all();
        return view('reminder.admincreate', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patientName' => 'required',
            'firstDate' => 'required|date|after_or_equal:today',
        ]);

        $patient = Patient::where('patientName', $request->patientName)->first();

        if (!$patient) {
            return back()->with('error', 'Patient not found.');
        }

        $first = Carbon::parse($request->firstDate);
        $second = $first->copy()->addMonths(6);
        $third = $first->copy()->addMonths(9);

        Reminder::create([
            'patientID' => $patient->patientID,
            'firstDate' => $first,
            'secondDate' => $second,
            'thirdDate' => $third,
        ]);

        return redirect()->route('admin.reminder.list')->with('success', 'Appointment reminder successfully scheduled.');
    }

    public function checkAvailability($date)
    {
        $exists = Reminder::where('firstDate', $date)->exists();
        return response()->json(['available' => !$exists]);
    }

    public function getBookedDates($year, $month)
    {
        $dates = Reminder::whereYear('firstDate', $year)
            ->whereMonth('firstDate', $month)
            ->pluck('firstDate')
            ->map(fn($d) => $d->toDateString());

        return response()->json(['bookedDates' => $dates]);
    }

    public function index()
    {
        $reminders = Reminder::with('patient')->get(); // assuming relationship is defined

        $totalReminders = $reminders->count();
        $today = Carbon::today();

        $todayReminders = $reminders->filter(function ($reminder) use ($today) {
            return $reminder->firstDate === $today->toDateString() ||
                $reminder->secondDate === $today->toDateString() ||
                $reminder->thirdDate === $today->toDateString();
        })->count();

        $completedReminders = $reminders->where('status', 'completed')->count();
        $overdueReminders = $reminders->filter(function ($reminder) use ($today) {
            return ($reminder->firstDate < $today && $reminder->firstStatus !== 'completed') ||
                ($reminder->secondDate < $today && $reminder->secondStatus !== 'completed') ||
                ($reminder->thirdDate < $today && $reminder->thirdStatus !== 'completed');
        })->count();

        return view('reminder.adminlist', compact(
            'reminders',
            'totalReminders',
            'todayReminders',
            'completedReminders',
            'overdueReminders'
        ));
    }

    // public function send(Request $request, $id)
    // {

    //     $request->validate([
    //         'reminderType' => 'required',
    //         'message' => 'nullable|string|max:500',
    //     ]);

    //     $patient = Patient::findOrFail($id);
    //     // dd([
    //     //     'ID' => $id,
    //     //     'Name' => $patient->patientName,
    //     //     'Tel' => $patient->patientTel,
    //     //     'Full object' => $patient,
    //     //     'Reminder Type' => $request->reminderType,
    //     //     'Message' => $request->message,
    //     // ]);

    //     $twilioSid = config('services.twilio.sid');
    //     $twilioToken = config('services.twilio.token');

    //     // $twilioFrom = 'whatsapp:+14155238886';
    //     $twilioFrom = 'whatsapp:' . config('services.twilio.whatsapp_from');


    //     $client = new Client($twilioSid, $twilioToken);

    //     $type = ucfirst($request->reminderType);
    //     $customMessage = $request->message
    //         ? "\n\nMessage: " . $request->message
    //         : '';

    //     $message = "Hello {$patient->patientName}, this is your {$type} reminder for your appointment." . $customMessage;


    //     $to = 'whatsapp:' . $patient->patientTel;
    //     try {
    //         $client->messages->create(
    //             $to,
    //             [
    //                 'from' => $twilioFrom,
    //                 'body' => $message
    //             ]
    //         );

    //         return back()->with('success', 'Reminder sent successfully via WhatsApp.');
    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Failed to send reminder: ' . $e->getMessage());
    //     }
    // }


    public function send(Request $request, $id)
    {
        $request->validate([
            'reminderType' => 'required',
            'message' => 'nullable|string|max:500',
        ]);

        $patient = Patient::findOrFail($id);
        $reminder = Reminder::where('patientID', $id)->first(); // Assuming 1 reminder per patient

        $twilioSid = config('services.twilio.sid');
        $twilioToken = config('services.twilio.token');
        $twilioFrom = config('services.twilio.sms_from');

        $client = new Client($twilioSid, $twilioToken);

        $type = ucfirst($request->reminderType);
        $customMessage = $request->message
            ? "\n\nMessage: " . $request->message
            : '';

        // Ensure the dates are Carbon instances and retrieve the correct date based on reminder type
        $reminderDate = '';
        if ($request->reminderType === 'first') {
            $reminderDate = Carbon::parse($reminder->firstDate)->toFormattedDateString(); // Format it as you want
        } elseif ($request->reminderType === 'second') {
            $reminderDate = Carbon::parse($reminder->secondDate)->toFormattedDateString();
        } elseif ($request->reminderType === 'third') {
            $reminderDate = Carbon::parse($reminder->thirdDate)->toFormattedDateString();
        }

        // Address and contact details
        $address = "ProGait P&O Centre Sdn Bhd - Kaki Palsu Specialist Malaysia, Address: 32-3, Jalan Tasik Selatan 3, Metro Centre, Bandar Tasik Selatan, 57000, Kuala Lumpur.";


        $message = "Hello {$patient->patientName}, this is your {$type} reminder on {$reminderDate} for your appointment.\n\nYour appointment is at {$address} \n\nFor any information regarding your appointment, please call this number: 0166789451". $customMessage;;


        $to = preg_replace('/^0/', '+60', $patient->patientTel);

        try {
            $client->messages->create($to, [
                'from' => $twilioFrom,
                'body' => $message
            ]);

            // ✅ Update the relevant reminder status column
            if ($reminder) {
                if ($request->reminderType === 'first') {
                    $reminder->firstStatus = 'sent';
                } elseif ($request->reminderType === 'second') {
                    $reminder->secondStatus = 'sent';
                } elseif ($request->reminderType === 'third') {
                    $reminder->thirdStatus = 'sent';
                }
                $reminder->save();
            }

            return back()->with('success', 'Reminder sent successfully via SMS.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send reminder: ' . $e->getMessage());
        }
    }



    // public function send(Request $request, $id)
    // {
    //     $patient = Patient::findOrFail($id);
    //     dd([
    //         'ID' => $id,
    //         'Name' => $patient->patientName ?? $patient->name,
    //         'Tel' => $patient->patientTel ?? $patient->phone,
    //         'Full object' => $patient
    //     ]);
    // }

// Staff-specific methods
    public function createStaff()
    {
        $patients = Patient::all();
        return view('reminder.staffcreate', compact('patients'));
    }

    public function storeStaff(Request $request)
    {
        $request->validate([
            'patientName' => 'required',
            'firstDate' => 'required|date|after_or_equal:today',
        ]);

        $patient = Patient::where('patientName', $request->patientName)->first();

        if (!$patient) {
            return back()->with('error', 'Patient not found.');
        }

        $first = Carbon::parse($request->firstDate);
        $second = $first->copy()->addMonths(6);
        $third = $first->copy()->addMonths(9);

        Reminder::create([
            'patientID' => $patient->patientID,
            'firstDate' => $first,
            'secondDate' => $second,
            'thirdDate' => $third,
        ]);

        return redirect()->route('staff.reminder.list')->with('success', 'Appointment reminder successfully scheduled.');
    }

    public function checkAvailabilityStaff($date)
    {
        $exists = Reminder::where('firstDate', $date)->exists();
        return response()->json(['available' => !$exists]);
    }

    public function getBookedDatesStaff($year, $month)
    {
        $dates = Reminder::whereYear('firstDate', $year)
            ->whereMonth('firstDate', $month)
            ->pluck('firstDate')
            ->map(fn($d) => $d->toDateString());

        return response()->json(['bookedDates' => $dates]);
    }

    public function indexStaff()
    {
        $reminders = Reminder::with('patient')->get(); // assuming relationship is defined

        $totalReminders = $reminders->count();
        $today = Carbon::today();

        $todayReminders = $reminders->filter(function ($reminder) use ($today) {
            return $reminder->firstDate === $today->toDateString() ||
                $reminder->secondDate === $today->toDateString() ||
                $reminder->thirdDate === $today->toDateString();
        })->count();

        $completedReminders = $reminders->where('status', 'completed')->count();
        $overdueReminders = $reminders->filter(function ($reminder) use ($today) {
            return ($reminder->firstDate < $today && $reminder->firstStatus !== 'completed') ||
                ($reminder->secondDate < $today && $reminder->secondStatus !== 'completed') ||
                ($reminder->thirdDate < $today && $reminder->thirdStatus !== 'completed');
        })->count();

        return view('reminder.stafflist', compact(
            'reminders',
            'totalReminders',
            'todayReminders',
            'completedReminders',
            'overdueReminders'
        ));
    }

    public function sendStaff(Request $request, $id)
    {
        $request->validate([
            'reminderType' => 'required',
            'message' => 'nullable|string|max:500',
        ]);

        $patient = Patient::findOrFail($id);
        $reminder = Reminder::where('patientID', $id)->first(); // Assuming 1 reminder per patient

        $twilioSid = config('services.twilio.sid');
        $twilioToken = config('services.twilio.token');
        $twilioFrom = config('services.twilio.sms_from');

        $client = new Client($twilioSid, $twilioToken);

        $type = ucfirst($request->reminderType);
        $customMessage = $request->message
            ? "\n\nMessage: " . $request->message
            : '';

        // Ensure the dates are Carbon instances and retrieve the correct date based on reminder type
        $reminderDate = '';
        if ($request->reminderType === 'first') {
            $reminderDate = Carbon::parse($reminder->firstDate)->toFormattedDateString(); // Format it as you want
        } elseif ($request->reminderType === 'second') {
            $reminderDate = Carbon::parse($reminder->secondDate)->toFormattedDateString();
        } elseif ($request->reminderType === 'third') {
            $reminderDate = Carbon::parse($reminder->thirdDate)->toFormattedDateString();
        }

        // Address and contact details
        $address = "ProGait P&O Centre Sdn Bhd - Kaki Palsu Specialist Malaysia, Address: 32-3, Jalan Tasik Selatan 3, Metro Centre, Bandar Tasik Selatan, 57000, Kuala Lumpur.";

        $message = "Hello {$patient->patientName}, this is your {$type} reminder on {$reminderDate} for your appointment.\n\nYour appointment is at {$address} \n\nFor any information regarding your appointment, please call this number: 0166789451". $customMessage;;

        $to = preg_replace('/^0/', '+60', $patient->patientTel);

        try {
            $client->messages->create($to, [
                'from' => $twilioFrom,
                'body' => $message
            ]);

            // ✅ Update the relevant reminder status column
            if ($reminder) {
                if ($request->reminderType === 'first') {
                    $reminder->firstStatus = 'sent';
                } elseif ($request->reminderType === 'second') {
                    $reminder->secondStatus = 'sent';
                } elseif ($request->reminderType === 'third') {
                    $reminder->thirdStatus = 'sent';
                }
                $reminder->save();
            }

            return back()->with('success', 'Reminder sent successfully via SMS.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send reminder: ' . $e->getMessage());
        }
    }

    public function destroyStaff($remID)
    {
        try {
            $reminder = Reminder::findOrFail($remID);
            $reminder->delete();
            
            return back()->with('success', 'Reminder deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete reminder: ' . $e->getMessage());
        }
    }
}
