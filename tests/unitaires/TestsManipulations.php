<?php 

/**
 * Class containing the method until to make tests
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class TestsManipulation {
    /**
     * Protected attribute containing the number of successed tests
     *
     * @var Int
     */
    protected int $successed_tests = 0;

    /**
     * Public function implementing the number of successed tests
     *
     * @return Void
     */
    public function successTest() { $this->successed_tests++; }
    /**
     * Public method setting the number of successed tests on 0
     *
     * @return Void
     */
    protected function resetSuccess() { $this->successed_tests = 0; }

    // * write * //
    /**
     * public static method writting in the page a SUCCESS test message
     *
     * @return Void
     */
    protected function writeSuccess() { 
        if($this->successed_tests === 0) 
            return;
        echo '<p style="display: flex; align-items: center; gap: 5px;"><img style="height: 20px"src="assets\success.png" alt="">' . $this->successed_tests . ' test(s) validé(s) !</p>'; 
        $this->resetSuccess();
    }
    /**
     * public static method writting in the page a failure test message
     *
     * @param String $test_name The name of test
     * @return Void
     */
    public function writeFailure(string $test_name) { 
        $this->writeSuccess();
        echo '<p style="display: flex; align-items: center; gap: 5px;"><img style="height: 20px"src="assets\failure.png" alt="">' . 'Erreur ! Test échoué : <b>' . $test_name . '</b>'; 
        exit; 
    }

    // * STATIC METHOD * //
    /**
     * Public static method returning the SUCCESS status
     *
     * @return Bool
     */
    public static function SUCCESS(): bool { return true; }
    /**
     * Public static method returning the SUCCESS status
     *
     * @return Bool
     */
    public static function FAILURE(): bool { return false; }

    //// write ////
    /**
     * public static method writting a message in a <h1> balise
     *
     * @param String $msg The message to write
     * @return Void
     */
    public static function writeH1(string $msg) { echo "<h1>" . $msg . "</h1>"; }
    /**
     * public static method writting a message in a <h2> balise
     *
     * @param String $msg The message to write
     * @return Void
     * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
     */
    public static function writeH2(string $msg) { echo "<h2>" . $msg . "</h2>"; }
    /**
     * public static method writting a message in a <h3> balise
     *
     * @param String $msg The message to write
     * @return Void
     * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
     */
    public static function writeH3(string $msg) { echo "<h3>" . $msg . "</h3>"; }
}