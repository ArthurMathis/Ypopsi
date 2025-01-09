<?php 

require_once('Moment.php');

// ! UNUSED ! //

/**
 *  Class representing one contract's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class InvalideContractExceptions extends Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}

/**
 * Class representing one candidate's contract
 * 
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class Contract {
    /**
     * Private attribute containing the contract's key
     * 
     * @var Int The contract's key
     */
    private $key = null;
    /**
     * Private attribute containing the candidate's key
     * 
     * @var Int The candidate's key
     */
    private $candidate;
    /**
     * Private attribute containing the establishment's key
     * 
     * @var Int The establishment's key
     */
    private $establishment;
    /**
     * Private attribute containing the service's key
     * 
     * @var Int The service's key
     */
    private $service;
    /**
     * Private attribute containing the job's key
     * 
     * @var Int The job's key
     */
    private $job;
    /**
     * Private attribute containing the contract's type
     * 
     * @var Int The contract's type
     */
    private $type;
    /**
     * Private attribute containing the moment when begins the contract
     * 
     * @var Moment The moment when begins the contract
     */
    private $start_date;
    /**
     * Private attribute containing the moment when ends the contract
     * 
     * @var Moment The moment when ends the contract
     */
    private $end_date = null;
    /**
     * Private attribute containing the moment when the candidate signed the contract
     * 
     * @var Moment The moment when the candidate signed the contract
     */
    private $signature = null;
    /**
     * Private attribute containing the moment when the candidate resigned the contract
     * 
     * @var Moment The moment when the candidate resigned the contract
     */
    private $resignation_date = null;
    /**
     * Private attribute containing the number of working hours in a week
     * 
     * @var Int The number of working hours in a week
     */
    private $hourly_rate = null;
    /**
     * Private attribute containing the candidate's salary
     * 
     * @var Int The candidate's salary
     */
    private $salary = null;
    /**
     * Private attribute notes if the candidate has to work the night or not
     * 
     * @var Bool TRUE - If he works the night ; FALSE - if not
     */
    private $night_work = false;
    /**
     * Private attribute notes if the candidate has to work the week-end or not
     * 
     * @var Bool TRUE - If he works the week-end ; FALSE - if not
     */
    private $wk_work = false;

    /**
     * Class' constructor
     * 
     * @param Int $candidate The candidate's key
     * @param Int $job The job's key
     * @param Int $service The service's key
     * @param Int $establishment The establishment's key
     * @param Int $type The type's key
     * @param String $start_date The moment when begins the contract
     * @throws InvalideContractExceptions If data is invalid
     */
    public function __construct(int $candidate, int $job, int $service, int $establishment, int $type, string $start_date) {
        $this->setCandidate($candidate);
        $this->setJob($job);
        $this->setService($service);
        $this->setEstablishment($establishment);
        $this->setType($type);
        $this->setStartDate($start_date);
    }

    // * GET * //
    /**
     *  Public method returning the contract's key
     * @return Int|NULL
     */
    public function getKey(): ?Int { return $this->key; }
    /**
     *  Public method returning the candidate's key
     * @return Int
     */
    public function getCandidate(): Int { return $this->candidate; }
    /**
     *  Public method returning the establishment's key
     * @return Int
     */
    public function getEstablishment(): Int { return $this->establishment; }
    /**
     *  Public method returning the service's key 
     * @return Int
     */
    public function getService(): Int { return $this->service; }
    /**
     *  Public method returning the job's key
     * @return Int
     */
    public function getJob(): Int { return $this->job; }
    /**
     *  Public method returning the type's key 
     * @return Int
     */
    public function getType(): Int { return $this->type; }
    /**
     *  Public method returning the moment when begins the contract
     * @return Moment
     */
    public function getStartDate(): Moment { return $this->start_date; }
    /**
     *  Public method returning the moment when ends the contract
     * @return Moment|NULL
     */
    public function getEndDate(): ?Moment { return $this->end_date; }
    /**
     *  Public method returning the moment when the candidate signed the contract
     * @return Moment|NULL
     */
    public function getSignature(): ?Moment { return $this->signature; }
    /**
     *  Public method returning the moment when the candidate resigned the contract
     * @return Moment|NULL
     */
    public function getResignationDate(): ?Moment { return $this->resignation_date; }
    /**
     *  Public method returning the number of working hours in a week
     * @return Int
     */
    public function getHourlyRate(): ?Int { return $this->hourly_rate; }
    /**
     *  Public method returning the contract's salary
     * @return Int
     */
    public function getSalary(): ?Int { return $this->salary; }
    /**
     *  Public method returning if the candidate has to work the week-end or not
     * @return Bool
     */
    public function getNightWork(): bool { return $this->night_work; }
    /**
     *  Public method returning if the candidate has to work the week-end or not
     * @return Bool
     */
    public function getWeekEndWork(): bool { return $this->wk_work; }

    // * SET * //
    /**
     * Public method setting the contract's key
     * 
     * @param Int|String $key The contract's key
     * @throws InvalideContractExceptions If the key is invalid
     * @return Void
     */
    public function setKey($key) { 
        if($key == null || !is_numeric($key)) 
            throw new InvalideContractExceptions("La clé du contrat doit être un entier !");
        elseif($key < 0) 
            throw new InvalideContractExceptions("La clé du contrat doit être strictement positive !");

        else $this->key = Intval($key);
    }
    /**
     * Private method setting the candidate's key
     * 
     * @param Int|String $candidate The candidate's key  
     * @throws InvalideContractExceptions If the key is invalid
     * @return Void
     */
    private function setCandidate($candidate) {
        if($candidate == null || !is_numeric($candidate)) 
            throw new InvalideContractExceptions("La clé d'un candidat doit être un entier !");
        elseif(Intval($candidate) < 0)
            throw new InvalideContractExceptions("La clé d'un candidat doit être strictement positive !");

        else  $this->candidate = Intval($candidate);
    }
    /**
     * Private method setting the establishment's key
     * 
     * @param Int|String $service The establishment's key  
     * @throws InvalideContractExceptions If the key is invalid
     * @return Void
     */
    private function setEstablishment($establishment) {
        if($establishment == null || !is_numeric($establishment)) 
            throw new InvalideContractExceptions("La clé d'un établissement doit être un entier !");
        elseif(Intval($establishment) < 0)
            throw new InvalideContractExceptions("La clé d'un établissement doit être strictement positive !");

        else  $this->establishment = Intval($establishment);
    }
    /**
     * Private method setting the service's key
     * 
     * @param Int|String $service The service's key  
     * @throws InvalideContractExceptions If the key is invalid
     * @return Void
     */
    private function setService($service) {
        if($service == null || !is_numeric($service)) 
            throw new InvalideContractExceptions("La clé d'un service doit être un entier !");
        elseif(Intval($service) < 0)
            throw new InvalideContractExceptions("La clé d'un service doit être strictement positive !");

        else  $this->service = Intval($service);
    }
    /**
     * Private method setting the job's key
     * 
     * @param Int|String $job The job's key  
     * @throws InvalideContractExceptions If the key is invalid
     * @return Void
     */
    private function setJob($job) {
        if($job == null || !is_numeric($job)) 
            throw new InvalideContractExceptions("La clé d'un poste doit être un entier !");
        elseif($job < 0)
            throw new InvalideContractExceptions("La clé d'un poste doit être strictement positive !");

        else  $this->job = Intval($job);
    }
    /**
     * Private method setting the job's key
     * 
     * @param Int|String $type The job's key  
     * @throws InvalideContractExceptions If the key is invalid
     * @return Void
     */
    private function setType($type) {
        // On vérifie la présence d'une clé
        if($type == null || !is_numeric($type)) 
            throw new InvalideContractExceptions("La clé d'un type de contrats doit être un entier !");
        elseif($type < 0)
            throw new InvalideContractExceptions("La clé d'un type de contrats doit être strictement positive !");

        // On implémente    
        else  $this->type = Intval($type);
    }
    /**
     *  Private method setting the moment when begins the contract
     * @param Moment $start_date The moment when begins the contract
     * @throws InvalideContractExceptions If $start_date is not of type 'Moment'
     * @return Void
     */
    private function setStartDate($start_date) { 
        if (!($start_date instanceof Moment)) 
            throw new InvalideContractExceptions("La date de début doit être de type 'Moment' !");
        
        $this->start_date = $start_date; 
    }
    /**
     * Private method setting the moment when ends the contract
     * 
     * @param Moment $end_date The moment when ends the contract
     * @throws InvalideContractExceptions If $end_date is not of type 'Moment'
     * @return Void
     */
    private function setEndDate($end_date) { 
        if (!($end_date instanceof Moment)) 
            throw new InvalideContractExceptions("La date de fin doit être de type 'Moment' !");
        $this->end_date = $end_date; 
    }
    
    /**
     * Private method setting the moment when the candidate signed the contract
     * 
     * @param Moment $signature The moment when the candidate signed the contract
     * @throws InvalideContractExceptions If $signature is not of type 'Moment'
     * @return Void
     */
    private function setSignature($signature) { 
        if (!($signature instanceof Moment)) 
            throw new InvalideContractExceptions("La date de signature doit être de type 'Moment' !");
        $this->signature = $signature; 
    }
    
    /**
     * Private method setting the moment when the candidate resigned the contract
     * 
     * @param Moment $resignation_date The moment when the candidate resigned the contract
     * @throws InvalideContractExceptions If $resignation_date is not of type 'Moment'
     * @return Void
     */
    private function setResignationDate($resignation_date) { 
        if (!($resignation_date instanceof Moment)) 
            throw new InvalideContractExceptions("La date de démission doit être de type 'Moment' !");
        $this->resignation_date = $resignation_date;  
    }
    /**
     * Private method setting the contract's salary
     * 
     * @param Int|String $salary The contract's salary
     * @throws InvalideContractExceptions If salary is invalid
     * @return Void
     */
    private function setSalary($salary) {
        if(!is_numeric($salary))
            throw new InvalideContractExceptions('Le salaire doit être un entier !');
        elseif(Intval($salary) <= 0)
            throw new InvalideContractExceptions('Le salaire ne peut pas être négatif ou nul !');

        else $this->salary = Intval($salary);
    }
    /**
     * Private method setting the number of working hours in a week
     * 
     * @param Int|String $salary The number of working hours in a week
     * @throws InvalideContractExceptions If hourly rate is invalid
     * @return Void
     */
    private function setHourlyRate($hourly_rate) {
        if(!is_numeric($hourly_rate))
            throw new InvalideContractExceptions("Le taux horaires hebdomadaire doit être un entier !");
        elseif($hourly_rate <= 0)
            throw new InvalidArgumentException("le taux horaires hebdomadaires ne peut pas être négatif ou nul !");

        else $this->hourly_rate = Intval($hourly_rate);
    }
    /**
     * Private method setting the attribute night_work on true
     * 
     * @return Void
     */
    private function setNightWork() { $this->night_work = true; }
    /**
     * Private method setting the attribute wk_work on true
     * 
     * @return Void
     */
    private function setWeekEndWork() { $this->wk_work = true; }

    // * STATIC * //
    /**
     * Public static method creating a contract from an data array
     * 
     * @param array $infos The array which contains the contracts' data
     * @throws InvalideContractExceptions If the array is no completed or if teh data are invalid
     * @return Contract The contract made from the array
     */
    public static function makeContract(array $infos): Contract {
        if(empty($infos) || !isset($infos['candidate']) || !isset($infos['job']) || !isset($infos['service']) || !isset($infos['establishment']) || !isset($infos['type']) || !isset($infos['start_date']))
            throw new InvalideContractExceptions('Données manquantes.');

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

                case 'night_work':
                    $contract->setNightWork();
                    break; 

                case 'week_end_work':
                    $contract->setWeekEndWork();
                    break; 

                case 'hourly_rate':
                    $contract->setHourlyRate($value);
                    break; 

                default: break;    
            } 
        }

        return $contract;
    }
    
    // ! Unused ! //
    /**
     * Public method returning the contract's data in an array
     * 
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
            $result['hourly rate'] = $this->getHourlyRate();
        
        return $result;
    }
}