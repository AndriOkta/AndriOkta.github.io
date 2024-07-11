<?php

namespace App\Classifier;

class NaiveBayesClassifier
{
    private $classProbabilities;
    private $featureProbabilities;

    public function fit($data)
    {
        $classCounts = [];
        $featureCounts = [];

        foreach ($data as $instance) {
            $class = $instance['class'];
            $classCounts[$class] = ($classCounts[$class] ?? 0) + 1;

            foreach ($instance as $feature => $value) {
                if ($feature === 'class') continue;

                if (!isset($featureCounts[$feature])) {
                    $featureCounts[$feature] = [];
                }
                if (!isset($featureCounts[$feature][$value])) {
                    $featureCounts[$feature][$value] = [];
                }
                if (!isset($featureCounts[$feature][$value][$class])) {
                    $featureCounts[$feature][$value][$class] = 0;
                }
                $featureCounts[$feature][$value][$class] += 1;
            }
        }

        $totalInstances = count($data);
        $this->classProbabilities = array_map(function ($count) use ($totalInstances) {
            return $count / $totalInstances;
        }, $classCounts);

        $this->featureProbabilities = [];

        foreach ($featureCounts as $feature => $valueCounts) {
            foreach ($valueCounts as $value => $classCounts) {
                foreach ($classCounts as $class => $count) {
                    $this->featureProbabilities[$feature][$value][$class] = $count / $classCounts[$class];
                }
            }
        }
    }

    public function predict($instance)
    {
        $maxProbability = -1;
        $bestClass = null;

        foreach ($this->classProbabilities as $class => $classProb) {
            $probability = $classProb;

            foreach ($instance as $feature => $value) {
                if (isset($this->featureProbabilities[$feature][$value][$class])) {
                    $probability *= $this->featureProbabilities[$feature][$value][$class];
                } else {
                    $probability *= 0.01; // Small probability for unseen feature values
                }
            }

            if ($probability > $maxProbability) {
                $maxProbability = $probability;
                $bestClass = $class;
            }
        }

        return $bestClass;
    }
}
