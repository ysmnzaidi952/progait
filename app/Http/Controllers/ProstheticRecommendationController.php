<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\ProstheticComponent;
use Illuminate\Support\Facades\Log;

class ProstheticRecommendationController extends Controller
{
    public function recommend(Request $request, $patientId)
    {
        // Get patient with their latest medical record
        $patient = Patient::findOrFail($patientId);
        
        // Get the latest medical record for this patient
        $medicalRecord = \DB::table('medical_records')
            ->where('patient_id', $patientId)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$medicalRecord) {
            if ($request->wantsJson()) {
                return response()->json([
                    'patient' => $patient,
                    'recommendations' => [],
                    'error' => 'No medical records found for this patient'
                ]);
            }
            
            return view('recommendation', [
                'patient' => $patient,
                'recommendations' => []
            ]);
        }
        
        // Extract patient fields from medical record
        $age = $this->calculateAge($patient->dateOfBirth ?? null);
        $bmi = $medicalRecord->bmi;
        $weight = $medicalRecord->weight_kg;
        $kLevel = $medicalRecord->k_level;
        $blart = $medicalRecord->blart_score;
        $amp = $medicalRecord->amputation_level;
        $health = $medicalRecord->health_condition;

        // Convert BMI to category
        $bmiCategory = $this->getBmiCategory($bmi);

        // Get recommendations based on medical record data
        $recommendations = $this->getRecommendations($amp, $age, $weight, $kLevel, $blart, $bmiCategory, $health);

        // Handle empty recommendations
        if (empty($recommendations)) {
            $recommendations = $this->getFallbackRecommendations($amp, $kLevel);
        }

        // Merge patient and medical record data for the view
        $patientData = (object) array_merge(
            (array) $patient->toArray(),
            [
                'amputation_level' => $medicalRecord->amputation_level,
                'k_level' => $medicalRecord->k_level,
                'blart_score' => $medicalRecord->blart_score,
                'weight' => $medicalRecord->weight_kg,
                'height' => $medicalRecord->height_cm,
                'bmi' => $medicalRecord->bmi,
                'health_condition' => $medicalRecord->health_condition,
                'age' => $age
            ]
        );

        return view('recommendation', [
            'patient' => $patientData,
            'recommendations' => $recommendations,
            'matching_criteria' => [
                'amputation_level' => $amp,
                'age' => $age,
                'weight' => $weight,
                'k_level' => $kLevel,
                'blart_score' => $blart,
                'bmi_category' => $bmiCategory
            ]
        ]);
    }

    private function calculateAge($dateOfBirth)
    {
        if (!$dateOfBirth) {
            return null;
        }
        return \Carbon\Carbon::parse($dateOfBirth)->age;
    }

    private function getBmiCategory($bmi)
    {
        if ($bmi < 18.5) {
            return 'Below average';
        } elseif ($bmi >= 18.5 && $bmi < 25) {
            return 'Average';
        } elseif ($bmi >= 25 && $bmi < 30) {
            return 'Above average';
        } else {
            return 'Obese';
        }
    }

    private function getRecommendations($ampLevel, $age, $weight, $kLevel, $blart, $bmiCategory, $health)
    {
        $recommendations = [];
        $ampType = $this->getAmputationType($ampLevel);
        
        if (in_array($ampType, ['Below Knee', 'Above Knee', 'Hip disarticulation'])) {
            // Lower limb recommendations (5 components)
            $recommendations['Foot Type'] = $this->getFootRecommendation($ampType, $kLevel, $weight, $age, $blart);
            $recommendations['Socket Type'] = $this->getSocketRecommendation($ampType, $kLevel, $age);
            $recommendations['Pylon/Tube'] = $this->getPylonRecommendation($ampType, $weight);
            $recommendations['Adapter'] = $this->getAdapterRecommendation($ampType, $kLevel);
            
            if (in_array($ampType, ['Above Knee', 'Hip disarticulation'])) {
                $recommendations['Knee Mechanism'] = $this->getKneeRecommendation($ampType, $kLevel, $weight, $age, $blart);
            } else {
                $recommendations['Suspension System'] = $this->getSuspensionRecommendation($ampType, $kLevel, $age);
            }
        }
        
        if (in_array($ampType, ['Below Elbow', 'Above Elbow'])) {
            // Upper limb recommendations (5 components)
            $recommendations['Terminal Device'] = $this->getTerminalDeviceRecommendation($ampLevel, $kLevel);
            $recommendations['Socket Type'] = $this->getSocketRecommendation($ampType, $kLevel, $age);
            $recommendations['Wrist Unit'] = $this->getWristRecommendation($ampLevel, $kLevel);
            $recommendations['Cable System'] = $this->getCableSystemRecommendation($ampLevel, $kLevel);
            
            if ($ampType === 'Above Elbow') {
                $recommendations['Elbow Unit'] = $this->getElbowRecommendation($ampLevel, $kLevel);
            }
        }

        $filteredRecommendations = array_filter($recommendations, function($rec) {
            return $rec !== null;
        });

        return array_slice($filteredRecommendations, 0, 5, true);
    }

    private function getAmputationType($ampLevel)
    {
        $mapping = [
            'Below Knee' => 'Below Knee',
            'Above Knee' => 'Above Knee', 
            'Hip disarticulation' => 'Hip disarticulation',
            'Below Elbow' => 'Below Elbow',
            'Above Elbow' => 'Above Elbow'
        ];
        return $mapping[$ampLevel] ?? $ampLevel;
    }

    private function getFootRecommendation($ampType, $kLevel, $weight, $age, $blart)
    {
        $query = ProstheticComponent::where('is_active', true)
            ->where('type', 'like', '%Foot%')
            ->where(function($q) use ($ampType) {
                $q->where('compatibility', 'like', "%{$ampType}%")
                  ->orWhere('compatibility', 'like', '%All%');
            });

        if ($kLevel) {
            $query->where(function($q) use ($kLevel) {
                $q->where('klevel_range', 'like', "%{$kLevel}%")
                  ->orWhere('klevel_range', 'like', '%All%');
            });
        }

      
        if ($weight > 0) {
            $query->where(function($q) use ($weight) {
                $q->where(function($subQ) use ($weight) {
                    $subQ->whereNull('weight_min')
                         ->orWhere('weight_min', '<=', $weight);
                })
                ->where(function($subQ) use ($weight) {
                    $subQ->whereNull('weight_max')
                         ->orWhere('weight_max', '>=', $weight);
                });
            });
        }

        return $query->orderByRaw("
            CASE 
                WHEN klevel_range LIKE '%K4%' THEN 4
                WHEN klevel_range LIKE '%K3%' THEN 3  
                WHEN klevel_range LIKE '%K2%' THEN 2
                WHEN klevel_range LIKE '%K1%' THEN 1
                ELSE 0
            END DESC
        ")->first();
    }

    private function getKneeRecommendation($ampType, $kLevel, $weight, $age, $blart)
    {
        if (!in_array($ampType, ['Above Knee', 'Hip disarticulation'])) {
            return null;
        }

        $query = ProstheticComponent::where('is_active', true)
            ->where('type', 'like', '%Knee%')
            ->where(function($q) use ($ampType) {
                $q->where('compatibility', 'like', "%{$ampType}%")
                  ->orWhere('compatibility', 'like', '%All%');
            });

        // Add weight filtering for knee components too
        if ($weight > 0) {
            $query->where(function($q) use ($weight) {
                $q->where(function($subQ) use ($weight) {
                    $subQ->whereNull('weight_min')
                         ->orWhere('weight_min', '<=', $weight);
                })
                ->where(function($subQ) use ($weight) {
                    $subQ->whereNull('weight_max')
                         ->orWhere('weight_max', '>=', $weight);
                });
            });
        }

        if ($kLevel) {
            $query->where(function($q) use ($kLevel) {
                $q->where('klevel_range', 'like', "%{$kLevel}%")
                  ->orWhere('klevel_range', 'like', '%All%');
            });
        }

        return $query->orderByRaw("
            CASE 
                WHEN klevel_range LIKE '%K4%' THEN 4
                WHEN klevel_range LIKE '%K3%' THEN 3  
                WHEN klevel_range LIKE '%K2%' THEN 2
                WHEN klevel_range LIKE '%K1%' THEN 1
                ELSE 0
            END DESC
        ")->first();
    }

    private function getSocketRecommendation($ampType, $kLevel, $age)
    {
        return ProstheticComponent::where('is_active', true)
            ->where('type', 'like', '%Socket%')
            ->where('compatibility', 'like', "%{$ampType}%")
            ->first();
    }

    private function getPylonRecommendation($ampType, $weight)
    {
        $query = ProstheticComponent::where('is_active', true)
            ->where('type', 'like', '%Tube%')
            ->where('compatibility', 'like', "%{$ampType}%");

        // Add weight filtering for pylon/tube components
        if ($weight > 0) {
            $query->where(function($q) use ($weight) {
                $q->where(function($subQ) use ($weight) {
                    $subQ->whereNull('weight_min')
                         ->orWhere('weight_min', '<=', $weight);
                })
                ->where(function($subQ) use ($weight) {
                    $subQ->whereNull('weight_max')
                         ->orWhere('weight_max', '>=', $weight);
                });
            });
        }

        return $query->first();
    }

    private function getAdapterRecommendation($ampType, $kLevel)
    {
        return ProstheticComponent::where('is_active', true)
            ->where('type', 'like', '%Adapter%')
            ->where('compatibility', 'like', "%{$ampType}%")
            ->first();
    }

    private function getSuspensionRecommendation($ampType, $kLevel, $age)
    {
        return ProstheticComponent::where('is_active', true)
            ->where('type', 'like', '%Suspension%')
            ->where('compatibility', 'like', "%{$ampType}%")
            ->first();
    }

    private function getTerminalDeviceRecommendation($ampLevel, $kLevel)
    {
        return ProstheticComponent::where('is_active', true)
            ->where('type', 'like', '%Terminal%')
            ->where('compatibility', 'like', "%{$this->getAmputationType($ampLevel)}%")
            ->first();
    }

    private function getElbowRecommendation($ampLevel, $kLevel)
    {
        return ProstheticComponent::where('is_active', true)
            ->where('type', 'like', '%Elbow%')
            ->where('compatibility', 'like', "%Above Elbow%")
            ->first();
    }

    private function getWristRecommendation($ampLevel, $kLevel)
    {
        return ProstheticComponent::where('is_active', true)
            ->where('type', 'like', '%Wrist%')
            ->where('compatibility', 'like', "%{$this->getAmputationType($ampLevel)}%")
            ->first();
    }

    private function getCableSystemRecommendation($ampLevel, $kLevel)
    {
        return ProstheticComponent::where('is_active', true)
            ->where('type', 'like', '%Cable%')
            ->where('compatibility', 'like', "%{$this->getAmputationType($ampLevel)}%")
            ->first();
    }

    private function getFallbackRecommendations($ampLevel, $kLevel)
    {
        $ampType = $this->getAmputationType($ampLevel);
        $recommendations = [];

        if (in_array($ampType, ['Below Knee', 'Above Knee', 'Hip disarticulation'])) {
            $recommendations['Foot Type'] = ProstheticComponent::where('is_active', true)->where('type', 'like', '%Foot%')->first();
            $recommendations['Socket Type'] = ProstheticComponent::where('is_active', true)->where('type', 'like', '%Socket%')->first();
            $recommendations['Pylon/Tube'] = ProstheticComponent::where('is_active', true)->where('type', 'like', '%Tube%')->first();
            $recommendations['Adapter'] = ProstheticComponent::where('is_active', true)->where('type', 'like', '%Adapter%')->first();
            
            if (in_array($ampType, ['Above Knee', 'Hip disarticulation'])) {
                $recommendations['Knee Mechanism'] = ProstheticComponent::where('is_active', true)->where('type', 'like', '%Knee%')->first();
            } else {
                $recommendations['Suspension System'] = ProstheticComponent::where('is_active', true)->where('type', 'like', '%Suspension%')->first();
            }
        }

        return array_filter($recommendations);
    }

    //admin section
    public function adminRecommend(Request $request, $patientId)
    {
        // Get patient with their latest medical record
        $patient = Patient::findOrFail($patientId);
        
        $medicalRecord = \DB::table('medical_records')
            ->where('patient_id', $patientId)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$medicalRecord) {
            return view('adminrecommendation', [
                'patient' => $patient,
                'recommendations' => [],
                'error' => 'No medical records found for this patient'
            ]);
        }

        $age = $this->calculateAge($patient->dateOfBirth ?? null);
        $bmi = $medicalRecord->bmi;
        $weight = $medicalRecord->weight_kg;
        $kLevel = $medicalRecord->k_level;
        $blart = $medicalRecord->blart_score;
        $amp = $medicalRecord->amputation_level;
        $health = $medicalRecord->health_condition;

        $bmiCategory = $this->getBmiCategory($bmi);
        $recommendations = $this->getRecommendations($amp, $age, $weight, $kLevel, $blart, $bmiCategory, $health);

        if (empty($recommendations)) {
            $recommendations = $this->getFallbackRecommendations($amp, $kLevel);
        }

        $patientData = (object) array_merge(
            (array) $patient->toArray(),
            [
                'amputation_level' => $medicalRecord->amputation_level,
                'k_level' => $medicalRecord->k_level,
                'blart_score' => $medicalRecord->blart_score,
                'weight' => $medicalRecord->weight_kg,
                'height' => $medicalRecord->height_cm,
                'bmi' => $medicalRecord->bmi,
                'health_condition' => $medicalRecord->health_condition,
                'age' => $age
            ]
        );

        return view('adminrecommendation', [
            'patient' => $patientData,
            'recommendations' => $recommendations,
            'matching_criteria' => [
                'amputation_level' => $amp,
                'age' => $age,
                'weight' => $weight,
                'k_level' => $kLevel,
                'blart_score' => $blart,
                'bmi_category' => $bmiCategory
            ]
        ]);
    }

    //staff recomendation
    public function staffRecommend(Request $request, $patientId)
    {
        $patient = Patient::findOrFail($patientId);
        
        $medicalRecord = \DB::table('medical_records')
            ->where('patient_id', $patientId)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$medicalRecord) {
            return view('staffrecommendation', [
                'patient' => $patient,
                'recommendations' => [],
                'error' => 'No medical records found for this patient'
            ]);
        }

        $age = $this->calculateAge($patient->dateOfBirth ?? null);
        $bmi = $medicalRecord->bmi;
        $weight = $medicalRecord->weight_kg;
        $kLevel = $medicalRecord->k_level;
        $blart = $medicalRecord->blart_score;
        $amp = $medicalRecord->amputation_level;
        $health = $medicalRecord->health_condition;

        $bmiCategory = $this->getBmiCategory($bmi);
        $recommendations = $this->getRecommendations($amp, $age, $weight, $kLevel, $blart, $bmiCategory, $health);

        if (empty($recommendations)) {
            $recommendations = $this->getFallbackRecommendations($amp, $kLevel);
        }

        $patientData = (object) array_merge(
            (array) $patient->toArray(),
            [
                'amputation_level' => $medicalRecord->amputation_level,
                'k_level' => $medicalRecord->k_level,
                'blart_score' => $medicalRecord->blart_score,
                'weight' => $medicalRecord->weight_kg,
                'height' => $medicalRecord->height_cm,
                'bmi' => $medicalRecord->bmi,
                'health_condition' => $medicalRecord->health_condition,
                'age' => $age
            ]
        );

        return view('staffrecommendation', [
            'patient' => $patientData,
            'recommendations' => $recommendations,
            'matching_criteria' => [
                'amputation_level' => $amp,
                'age' => $age,
                'weight' => $weight,
                'k_level' => $kLevel,
                'blart_score' => $blart,
                'bmi_category' => $bmiCategory
            ]
        ]);
    }

}