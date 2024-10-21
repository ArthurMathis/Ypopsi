<?php

require_once('Controller.php');
require_once(CLASSE.DS.'Candidate.php');

class CandidaturesController extends Controller {
    public function __construct() {
        $this->loadModel('CandidaturesModel');
        $this->loadView('CandidaturesView');
    }

    public function dispayCandidatures() {
        $items = $this->Model->getCandidatures();
        return $this->View->getContent("Candidatures", $items);
    }
    public function displaySaisieCandidat() {
        return $this->View->getSaisieCandidatContent(
            'Ypopsi - Nouveau candidat', 
            $this->Model->getQualifications(),
            $this->Model->getHelps(),
            $this->Model->getEmployee()
        );
    }
    public function displaySaisieCandidature() {
        return $this->View->getSaisieCandidatureContent(
            "Ypopsi - Recherche d'un candidat", 
            $this->Model->getAutoCompJobs(),
            $this->Model->getAutoCompServices(),
            $this->Model->getAutoCompTypesContracts(),
            $this->Model->getAutoCompSources()
        );
    }

    /**
     * Public method checking the new candidate's data, before redirecting the user to the application form
     *
     * @param Array $candidate The new candidate's data array
     * @param Array $qualifications The new candidate's qualifications array
     * @param Array $helps The new candidate's elps array
     * @param Date $medical_visit The expiration date of the new candidate's medical examination
     * @param Int $coopteur The employee co-opting the new candidate
     * @return Void
     */
    public function checkCandidat(&$candidate=[], $qualifications=[], $helps=[], $medical_visit, $coopteur) {
        $this->Model->verify_candidat($candidate, $qualifications, $helps, $medical_visit, $coopteur);
        header('Location: index.php?candidatures=saisie-candidature');
    }
    public function findCandidat($name, $firstname, $email=null, $phone=null) {
        $search = $this->Model->searchCandidat($name, $firstname, $email, $phone);
        try {
            $candidate = new Candidate(
                $search['name'],
                $search['firstname'],
                $search['email'],
                $search['phone'],
                $search['address'],
                $search['city'],
                $search['postcode']
            );
            $candidate->setKey($search['Id']);
            
        } catch(InvalideCandidateExceptions $e) {
            forms_manip::error_alert($e->getMessage());
        }

        $_SESSION['candidat'] = $candidate;

        header('Location: index.php?candidatures=saisie-candidature');
    }

    public function createCandidature($candidate, &$application=[], &$qualifications=[], &$helps=[], $coopteur) {
        $candidate->setAvailability($application['availability']);
        if($candidate->getKey() === null) {
            try {
                $search = $this->Model->searchCandidate($candidate->getName(), $candidate->getFirstname(), $candidate->getEmail());

            } catch(Exception $e) {
                forms_manip::error_alert([
                    'title' => "Erreur lors de l'inscription de la candidature",
                    'msg' => $e
                ]);
            }
            
            if(empty($search)) {
                $this->Model->createCandidat($candidate, $qualifications, $helps, $coopteur);

            } else 
                $candidate->setKey($search['Id']);
        }

        $this->Model->inscriptCandidature($candidate, $application);
        
        alert_manipulation::alert([
            'title' => 'Candidat inscript !',
            'msg' => strtoupper($candidate->getNom()) . " " . forms_manip::nameFormat($candidate->getPrenom()) . " a bien été inscrit(e).",
            'direction' => "index.php?candidats=" . $candidate->getCle()
        ]);
    }
}