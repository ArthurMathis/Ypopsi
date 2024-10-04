<?php 

require_once('Moment.php');

/**
 * @brief Class representing one contract's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class InvalideContractExceptions extends Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}

/**
 * @brief Class representing one candidate's contract
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class Contract {
    /**
     * @brief Private attribute containing the contract's key
     * @var Int The contract's key
     */
    private $key = null;
    /**
     * @brief Private attribute containing the candidate's key
     * @var Int The candidate's key
     */
    private $candidate;
    /**
     * @brief Private attribute containing the establishment's key
     * @var Int The establishment's key
     */
    private $establishment;
    /**
     * @brief Private attribute containing the service's key
     * @var Int The service's key
     */
    private $service;
    /**
     * @brief Private attribute containing the job's key
     * @var Int The job's key
     */
    private $job;
    /**
     * @brief Private attribute containing the contract's type
     * @var Int The contract's type
     */
    private $type;
    /**
     * @brief Private attribute containing the moment when begins the contract
     * @var String The moment when begins the contract
     */
    private $start_date;
    /**
     * @brief Private attribute containing the moment when ends the contract
     * @var String The moment when ends the contract
     */
    private $end_date = null;
    /**
     * @brief Private attribute containing the moment when the candidate signed the contract
     * @var String The moment when the candidate signed the contract
     */
    private $signature = null;
    /**
     * @brief Private attribute containing the moment when the candidate resigned the contract
     * @var String The moment when the candidate resigned the contract
     */
    private $resignation_date = null;
    /**
     * @brief Private attribute containing the number of working hours in a week
     * @var Int The number of working hours in a week
     */
    private $hourly_rate = null;
    /**
     * @brief Private attribute containing the candidate's salary
     * @var Int The candidate's salary
     */
    private $salary = null;
    /**
     * @brief Private attribute notes if the candidate has to work the night or not
     * @var Bool TRUE - If he works the night ; FALSE - if not
     */
    private $night_work = false;
    /**
     * @brief Private attribute notes if the candidate has to work the week-end or not
     * @var Bool TRUE - If he works the week-end ; FALSE - if not
     */
    private $wk_work = false;

    /**
     * @brief Class' constructor
     * @param Int|String $candidate The candidate's key
     * @param Int|String $job The job's key
     * @param Int|String $service The service's key
     * @param Int|String $establishment The establishment's key
     * @param Int|String $type The type's key
     * @param String $start_date The moment when begins the contract
     * @throws InvalideContractExceptions If data is invalid
     */
    public function __construct($candidate, $job, $service, $establishment, $type, $start_date) {
        $this->setCandidate($candidate);
        $this->setJob($job);
        $this->setService($service);
        $this->setEstablishment($establishment);
        $this->setType($type);
        $this->setStartDate($start_date);
    }

    /**
     * @brief Public static method creating a contract from an data array
     * @param array $infos The array which contains the contracts' data
     * @throws InvalideContractExceptions If the array is no completed or if teh data are invalid
     * @return Contract The contract made from the array
     */
    public static function makeContract($infos=[]): Contract {
        if(empty($infos) || !isset($infos['candidate']) || !isset($infos['job']) || !isset($infos['service']) || !isset($infos['establishment']) || !isset($infos['type']) || !isset($infos['start_date']))
            throw new InvalideContractExceptions('Donnnées éronnées. Champs manquants.');

        $contract = new Contract($infos['candidate'], $infos['job'], $infos['service'], $infos['establishment'], $infos['type'], $infos['start_date']);
        if(count($infos) === 6) 
            return $contract;            
        foreach($infos as $key => $value) {
            switch($key) {
                case 'key': 
                    $contract->setKey($value);
                    break;

                case 'end_date':
                    $contract->setEndDate($value);
                    break;

                case 'salary':
                    $contract->setSalary($value);
                    break;    

                case 'resignation_date':
                    $contract->setResignationDate($value);
                    break;

                case 'signature': 
                    $contract->setSignature($value);
                    break;    

                case 'night work':
                    $contract->setNightWork();
                    break; 

                case 'week-end work':
                    $contract->setWeekEndWork();
                    break; 

                case 'hourly rate':
                    $contract->setHourlyRate($value);
                    break; 

                default: break;    
            } 
        }

        return $contract;
    }

    /**
     * @brief Public method returning the contract's key
     * @return Int|NULL
     */
    public function getKey(): ?int { return $this->key; }
    /**
     * @brief Public method returning the candidate's key
     * @return Int
     */
    public function getCandidate(): int { return $this->candidate; }
    /**
     * @brief Public method returning the establishment's key
     * @return Int
     */
    public function getEstablishment(): int { return $this->establishment; }
    /**
     * @brief Public method returning the service's key 
     * @return Int
     */
    public function getService(): int { return $this->service; }
    /**
     * @brief Public method returning the job's key
     * @return Int
     */
    public function getJob(): int { return $this->job; }
    /**
     * @brief Public method returning the type's key 
     * @return Int
     */
    public function getType(): int { return $this->type; }
    /**
     * @brief Public method returning the moment when begins the contract
     * @return String
     */
    public function getStartDate(): string { return $this->start_date; }
    /**
     * @brief Public method returning the moment when ends the contract
     * @return String|NULL
     */
    public function getEndDate(): ?string { return $this->end_date; }
    /**
     * @brief Public method returning the moment when the candidate signed the contract
     * @return String|NULL
     */
    public function getSignature(): ?string { return $this->signature; }
    /**
     * @brief Public method returning the moment when the candidate resigned the contract
     * @return String|NULL
     */
    public function getResignationDate(): ?string { return $this->resignation_date; }
    /**
     * @brief Public method returning the number of working hours in a week
     * @return Int
     */
    public function getHourlyRate(): ?int { return $this->hourly_rate; }
    /**
     * @brief Public method returning the contract's salary
     * @return Int
     */
    public function getSalary(): ?int { return $this->salary; }
    /**
     * @brief Public method returning if the candidate has to work the week-end or not
     * @return Bool
     */
    public function getNightWork(): bool { return $this->night_work; }
    /**
     * @brief Public method returning if the candidate has to work the week-end or not
     * @return Bool
     */
    public function getWeekEndWork(): bool { return $this->wk_work; }

    /**
     * @brief Public method setting the contract's key
     * @param Int|String $key The contract's key
     * @throws InvalideContractExceptions If the key is invalid
     * @return void
     */
    public function setKey($key) { 
        if($key == null || !is_numeric($key)) 
            throw new InvalideContractExceptions("La clé du contrat doit être un entier !");
        elseif($key < 0) 
            throw new InvalideContractExceptions("La clé du contrat doit être strictement positive !");

        else $this->key = intval($key);
    }
    /**
     * @brief Private method setting the candidate's key
     * @param Int|String $candidate The candidate's key  
     * @throws InvalideContractExceptions If the key is invalid
     * @return void
     */
    private function setCandidate($candidate) {
        if($candidate == null || !is_numeric($candidate)) 
            throw new InvalideContractExceptions("La clé d'un candidat doit être un entier !");
        elseif(intval($candidate) < 0)
            throw new InvalideContractExceptions("La clé d'un candidat doit être strictement positive !");

        else  $this->candidate = intval($candidate);
    }
    /**
     * @brief Private method setting the establishment's key
     * @param Int|String $service The establishment's key  
     * @throws InvalideContractExceptions If the key is invalid
     * @return void
     */
    private function setEstablishment($establishment) {
        if($establishment == null || !is_numeric($establishment)) 
            throw new InvalideContractExceptions("La clé d'un établissement doit être un entier !");
        elseif(intval($establishment) < 0)
            throw new InvalideContractExceptions("La clé d'un établissement doit être strictement positive !");

        else  $this->establishment = intval($establishment);
    }
    /**
     * @brief Private method setting the service's key
     * @param Int|String $service The service's key  
     * @throws InvalideContractExceptions If the key is invalid
     * @return void
     */
    private function setService($service) {
        if($service == null || !is_numeric($service)) 
            throw new InvalideContractExceptions("La clé d'un service doit être un entier !");
        elseif(intval($service) < 0)
            throw new InvalideContractExceptions("La clé d'un service doit être strictement positive !");

        else  $this->service = intval($service);
    }
    /**
     * @brief Private method setting the job's key
     * @param Int|String $job The job's key  
     * @throws InvalideContractExceptions If the key is invalid
     * @return void
     */
    private function setJob($job) {
        if($job == null || !is_numeric($job)) 
            throw new InvalideContractExceptions("La clé d'un poste doit être un entier !");
        elseif($job < 0)
            throw new InvalideContractExceptions("La clé d'un poste doit être strictement positive !");

        else  $this->job = intval($job);
    }
    /**
     * @brief Private method setting the job's key
     * @param Int|String $type The job's key  
     * @throws InvalideContractExceptions If the key is invalid
     * @return void
     */
    private function setType($type) {
        // On vérifie la présence d'une clé
        if($type == null || !is_numeric($type)) 
            throw new InvalideContractExceptions("La clé d'un type de contrats doit être un entier !");
        elseif($type < 0)
            throw new InvalideContractExceptions("La clé d'un type de contrats doit être strictement positive !");

        // On implémente    
        else  $this->type = intval($type);
    }
    /**
     * @brief Private method setting the moment when begins the contract
     * @param String $start_date The moment when begins the contract
     * @throws InvalideContractExceptions If date is invalid
     * @return void
     */
    private function setStartDate($start_date) { 
        if(!is_string($start_date))
            throw new InvalideContractExceptions('La date de début de contratdoit être saisie dans une chaine de caractères !');
        elseif(!Moment::isDate($start_date))
            throw new InvalideContractExceptions("La date de début de contrat doit être une date !");
        
        $this->start_date = $start_date;
    }
    /**
     * @brief Private method setting the moment when ends the contract
     * @param String $start_date The moment when ends the contract
     * @throws InvalideContractExceptions If date is invalid
     * @return void
     */
    private function setEndDate($end_date) {
        if(empty($end_date))
            throw new InvalideContractExceptions('La date de fin de contrat doit être saisie !');
        elseif(!Moment::isDate($end_date))
            throw new InvalideContractExceptions("La date de fin de contrat doit être une date !");
        elseif(Moment::fromDate($this->getStartDate())->IsTallerOrEqualTo(Moment::fromDate($end_date)->getTimestamp()))
            throw new InvalideContractExceptions("La date de fin de contrat ne peut être antérieure à la date de début du contrat !");

        $this->end_date = $end_date;
    }
    /**
     * @brief Private method setting the moment when the candidate signed the contract
     * @param String $signature The moment when the candidate signed the contract
     * @throws InvalideContractExceptions If date is invalid
     * @return void
     */
    private function setSignature($signature) {
        try {
            if(empty($signature))
                throw new InvalideContractExceptions('La date de signature de contrat doit être saisie !');
            elseif(!Moment::isDate($signature))
                throw new InvalideContractExceptions("La date de signature de contrat doit être une date !");
            elseif($this->getEndDate() && Moment::fromDate($signature)->isTallerOrEqualTo(Moment::fromDate($this->getEndDate())->getTimestamp()))
                throw new InvalideContractExceptions("La date de signature du contrat doit être antérieure à la date de fin du contrat !"); 
        } catch(Exception $e) {
            echo $e->getMessage() . '<br>';
        }
        
        $this->signature = $signature;
    }
    /**
     * @brief Private method setting the moment when the candidate resigned the contract
     * @param String $start_date The moment when the candidate resigned the contract
     * @throws InvalideContractExceptions If date is invalid
     * @return void
     */
    private function setResignationDate($resignation_date) {
        if(empty($resignation_date))
            throw new InvalideContractExceptions('La date de démission doit être saisie !');
        elseif(!Moment::isDate($resignation_date))
            throw new InvalideContractExceptions("La date de démission doit être une date !");
        elseif(!empty($this->getEndDate()) && Moment::fromDate($resignation_date)->isTallerOrEqualTo(Moment::fromDate($this->getEndDate())->getTimestamp()))
            throw new InvalideContractExceptions("La date de démission du contrat doit être antérieure à la date de fin du contrat !");
        
        $this->resignation_date = $resignation_date;
    }
    /**
     * @brief Private method setting the contract's salary
     * @param Int|String $salary The contract's salary
     * @throws InvalideContractExceptions If salary is invalid
     * @return void
     */
    private function setSalary($salary) {
        if(!is_numeric($salary))
            throw new InvalideContractExceptions('Le salaire doit être un entier !');
        elseif(intval($salary) <= 0)
            throw new InvalideContractExceptions('Le salaire ne peut pas être négatif ou nul !');

        else $this->salary = intval($salary);
    }
    /**
     * @brief Private method setting the number of working hours in a week
     * @param Int|String $salary The number of working hours in a week
     * @throws InvalideContractExceptions If hourly rate is invalid
     * @return void
     */
    private function setHourlyRate($hourly_rate) {
        if(!is_numeric($hourly_rate))
            throw new InvalideContractExceptions("Le taux horaires hebdomadaire doit être un entier !");
        elseif($hourly_rate <= 0)
            throw new InvalidArgumentException("le taux horaires hebdomadaires ne peut pas être négatif ou nul !");

        else $this->hourly_rate = intval($hourly_rate);
    }
    /**
     * @brief Private method setting the attribute night_work on true
     * @return void
     */
    private function setNightWork() { $this->night_work = true; }
    /**
     * @brief Private method setting the attribute wk_work on true
     * @return void
     */
    private function setWeekEndWork() { $this->wk_work = true; }
    
    /**
     * @brief Public method returning the contract's data in an array
     * @return array The array
     */
    public function exportToSQL(): array {
        $result = [
            "candidate key" => $this->getCandidate(),
            "establishment key" => $this->getEstablishment(),
            "service key" => $this->getService(),
            "job key" => $this->getJob(),
            "type key" => $this->getType(),
            "start date" => $this->getStartDate(),
            "signature" => $this->getSignature() != null ? $this->getSignature() : NULL
        ];
        
        if($this->getKey() != null)
            $result['contract key'] = $this->getKey();
        if($this->getEndDate() != null)
            $result["end date"] = $this->getEndDate();
        if($this->getSalary() != null)
            $result['salary'] = $this->getSalary();
        if($this->getResignationDate() != null)
            $result['resignation date'] = $this->getResignationDate();
        if($this->getNightWork())
            $result['night work'] = $this->getNightWork();
        if($this->getWeekEndWork())
            $result['week end work'] = $this->getWeekEndWork();
        if($this->getHourlyRate() != null)
            $result['horuly rate'] = $this->getHourlyRate();
        
        return $result;
    }
}