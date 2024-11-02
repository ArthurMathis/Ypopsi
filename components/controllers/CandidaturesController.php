<?php

require_once('Controller.php');
require_once(CLASSE.DS.'Candidate.php');

class CandidaturesController extends Controller {
    /**
     * Class' constructor
     */
    public function __construct() {
        $this->loadModel('CandidaturesModel');
        $this->loadView('CandidaturesView');
    }

    /**
     * Public method generating the applications' main page
     *
     * @return Void
     */
    public function dispayCandidatures() {
        $items = $this->Model->getCandidatures();
        return $this->View->getContent("Candidatures", $items);
    }
    public function displayInputCandidate() {
        return $this->View->getInputCandidatesContent(
            'Ypopsi - Nouveau candidat', 
            $this->Model->getQualifications(),
            $this->Model->getHelps(),
            $this->Model->getEmployee()
        );
    }
    public function displayInputApplications() {
        return $this->View->displayInputApplicationsContent(
            "Ypopsi - Recherche d'un candidat", 
            $this->Model->getJobs(),
            $this->Model->getServices(),
            $this->Model->getEstablishments(),
            $this->Model->getTypesOfContracts(),
            $this->Model->getSources()
        );
    }

    /**
     * Public method checking the new candidate's data, before redirecting the user to the application form
     *
     * @param Array $candidate The new candidate's data array
     * @param Array $qualifications The new candidate's qualifications array
     * @param Array $helps The new candidate's helps array
     * @param Date $medical_visit The expiration date of the new candidate's medical examination
     * @param String $coopteur A string containing a concatenation of the first and last name of the employee advising the new candidate
     * @return Void
     */
    public function checkCandidate(&$candidate=[], $qualifications=[], $helps=[], $medical_visit, $coopteur) {
        $this->Model->verifyCandidate($candidate, $qualifications, $helps, $medical_visit, $coopteur);
        header('Location: index.php?applications=input-applications');
    }
    public function findCandidat($name, $firstname, $email=null, $phone=null) {
        $search = $this->Model->searchCandidat($name, $firstname, $email, $phone);
        try {
            $candidate = new Candidate(
                $search['name'],
                $search['firstname'],
                $search['gender'],
                $search['email'],
                $search['phone'],
                $search['address'],
                $search['city'],
                $search['postcode']
            );
            $candidate->setKey($search['id']);
            
        } catch(InvalideCandidateExceptions $e) {
            forms_manip::error_alert($e->getMessage());
        }

        $_SESSION['candidat'] = $candidate;

        header('Location: index.php?applications=input-offers');
    }
    /**
     * Public method generating and registering a new application
     *
     * @param Candidate $candidate The object containing the candidate's data
     * @param Array $application The array containing the application's data
     * @param Array $qualifications The array containing the candidate's qualifications
     * @param Array $helps The new candidate's helps array
     * @param String $coopteur The employee's name who advises the new candidate 
     * @return Void
     */
    public function createApplications(&$candidate, &$application=[], &$qualifications=[], &$helps=[], $coopteur) {
        $candidate->setAvailability($application['availability']);
        try {
            if($candidate->getKey() === null) {
                $search = $this->Model->searchCandidatesByName($candidate->getName(), $candidate->getFirstname(), $candidate->getEmail());

                if(empty($search)) 
                    $this->Model->createCandidate($candidate, $qualifications, $helps, $coopteur);
                else 
                    $candidate->setKey($search['Id']);
            }
            
            $this->Model->inscriptApplication($candidate, $application);

        } catch(Exception $e) {
            forms_manip::error_alert([
                'title' => "Erreur lors de l'inscription de la candidature",
                'msg' => $e
            ]);
        } 

        alert_manipulation::alert([
            'title' => 'Candidat inscript !',
            'msg' => strtoupper($candidate->getName()) . " " . forms_manip::nameFormat($candidate->getFirstname()) . " a bien été inscrit(e).",
            'direction' => "index.php?candidates=" . $candidate->getKey()
        ]);
    }
}