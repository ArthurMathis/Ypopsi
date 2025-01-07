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
    /**
     * Public method returning the input candidate form
     *
     * @return View HTML Page
     */
    public function displayInputCandidate() {
        return $this->View->displayInputCandidatesContent(
            'Ypopsi - Nouveau candidat', 
            $this->Model->getQualificationsForAutoComplete(),
            $this->Model->getHelpsForAutoComplete(),
            $this->Model->getEmployeeForAutoComplete()
        );
    }
    /**
     * Public method returning the input application form
     *
     * @return View HTML Page
     */
    public function displayInputApplications() {
        return $this->View->displayInputApplicationsContent(
            "Ypopsi - Recherche d'un candidat", 
            $this->Model->getJobsForAutoComplete(),
            $this->Model->getServicesForAutoComplete(),
            $this->Model->getEstablishmentsForAutoComplete(),
            $this->Model->getTypesOfContractsForAutoComplete(),
            $this->Model->getSourcesForAutoComplete()
        );
    }

    /**
     * Public method checking the new candidate's data, before redirecting the user to the application form
     *
     * @param Array $candidate The new candidate's data array
     * @param Array|Null $qualifications The new candidate's qualifications array
     * @param Array|Null $helps The new candidate's helps array
     * @param String|Null $medical_visit The expiration date of the new candidate's medical examination
     * @param String|Null $coopteur A string containing a concatenation of the first and last name of the employee advising the new candidate
     * @return Void
     */
    public function checkCandidate(array $candidate, ?array $qualifications = null, array|null $helps = null, string|null $medical_visit = null, string|null $coopteur = null) {
        $this->Model->verifyCandidate($candidate, $qualifications, $helps, $medical_visit, $coopteur);
        header('Location: index.php?applications=input-applications');
    }
    /**
     * Public method generating and registering a new application
     *
     * @param Candidate $candidate The object containing the candidate's data
     * @param Int $key_sources The primary key of the source of the application
     * @param String $availability The date from which the candidate is available
     * @param Int $key_jobs The primary key of the job of the application
     * @param Int|Null $key_services The primary key of the service of the application
     * @param Int|Null $key_establishments The primary key of the establishment of the application
     * @param Int|Null $key_type_of_contract The primary key of the type of contract of the application
     * @param Array|Null $qualifications The array containing the candidate's list of qualifications
     * @param Array|Null $helps The array containing the candidate's list of helps
     * @param String|Null $coopteur The 
     * @param Array|Null $key_needs
     * @throws Exception|PDOException If the request is not integred
     * @return Void
     */
    public function createApplications(Candidate $candidate, int $key_sources, string $availability, int $key_jobs, ?int $key_services = null, ?int $key_establishments = null, ?int $key_type_of_contract = null, ?array $qualifications = null, ?array $helps = null, ?int $coopteur = null, ?array $key_needs = null) { 
        $candidate->setAvailability($availability);
        if($key_services && $key_establishments && !$this->Model->verifyServices($key_services, $key_establishments))
            throw new Exception("Le service " . $this->Model->searchServices($key_services)['Titled'] . " n'existe pas dans l'établissement " . $this->Model->searchEstablishmets($key_establishments)['Titled'] . "...");
        if(!$candidate->getKey()) {
            $this->Model->createCandidate($candidate, $qualifications, $helps, $coopteur); 
            $this->Model->writeLogs(
                $_SESSION['user_key'], 
                "Nouveau candidat", 
                "Inscription du candidat " . strtoupper($candidate->getName()) . " " . forms_manip::nameFormat($candidate->getFirstname())
            );
        }
        
        $this->Model->inscriptApplications($candidate->getKey(), $key_sources, $key_jobs, $key_type_of_contract, $key_services, $key_establishments, $key_needs);
        $this->Model->writeLogs(
            $_SESSION['user_key'], 
            "Nouvelle candidature", 
            "Nouvelle candidature de " . strtoupper($candidate->getName()) . " " . forms_manip::nameFormat($candidate->getFirstname()) . " au poste de " . $this->Model->searchJobs($key_jobs)['Titled']
        );
    }
}