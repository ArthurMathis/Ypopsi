import sys
import time
import re 

from datetime import datetime
from dateutil.relativedelta import relativedelta

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

from define import write

class TestRunner:
    """
    Classe développée pour exécuter des tests de fonctionnalités sur l'application Ypopsi.
    Cette classe utilise Selenium WebDriver pour automatiser les tests d'interface utilisateur.

    Attributs:
        Colors : 
        - BLUE : Code couleur pour les messages d'information
        - RED : Code couleur pour les messages d'échec
        - GREEN : Code couleur pour les messages de succès
        - RESET : Code couleur des textes de base
        
        Sleeps :
        - SLEEP_TIME : Le temps de pause (en secondes) entre les actions
        - LOADING_TIME : Le temps de pause (en secondes) nécessaire au chargement d'une nouvelle page
        - WAITED_TIME : Le temps d'attente (en secondes) pour la détection d'u élément de la page 
        
        URL :
        - APP_URL : L'adresse de l'application Ypopsi
        - APP_ID : L'identifiant de connexion pour les tests
        - APP_PASSWORD : Le mot de passe de la session de test
        
        Links : 
        - APP_HOME_PAGE_LINK : Le lien vers la page d'accueil
        - APP_CONNEXION_FORM_LINK : Le lien vers le formulaire de connexion
        - APP_APPLICATIONS_PAGE_LINK : Le lien vers le menu de candidatures
        - APP_PREFERENCES_PAGE_LINK : Le lien vers le menu de préférences
        
        Candidates : 
        - APP_CANDIDATES_NAME_1 : Le nom du candidat de test numéro 1
        - APP_CANDIDATES_FISTNAME_1 : Le prénom du candidat de test numéro 1
        - APP_CANDIDATES_EMAIL_1 : L'email du candidat de test numéro 1
        - APP_CANDIDATES_PHONE_1 : Le téléphone du candidat de test numéro 1
        - APP_CANDIDATES_GENDER_1 : Le genre du candidat numéro 1
        
        - APP_CANDIDATES_JOB_1 : L'emploi du candidat numéro 1
        - APP_CANDIDATES_SERVICE_1 : Le service du candidat numéro 1
        - APP_CANDIDATES_ESTABLISHMENT_1 : L'établissement du candidat numéro 1
        - APP_CANDIDATES_CONTRACT_TYPE_1 : Le type de contrat du candidat numéro 1
        - APP_CANDIDATES_SOURCE_1 : La source de la candidature du candidat numéro 1
        - APP_CANDIDATES_AVAILABILITY_1 : La date de disponibilité du candidat numéro 1
        

        - APP_CANDIDATES_NAME_2 : Le nom du candidat de test numéro 2
        - APP_CANDIDATES_FISTNAME_2 : Le prénom du candidat de test numéro 2
        - APP_CANDIDATES_EMAIL_2 : L'email du candidat de test numéro 2
        - APP_CANDIDATES_PHONE_2 : Le téléphone du candidat de test numéro 2
        
        - APP_CANDIDATES_JOB_2 : L'emploi du candidat numéro 2
        - APP_CANDIDATES_SERVICE_2 : Le service du candidat numéro 2
        - APP_CANDIDATES_ESTABLISHMENT_2 : L'établissement du candidat numéro 2
        - APP_CANDIDATES_CONTRACT_TYPE_2 : Le type de contrat du candidat numéro 2
        - APP_CANDIDATES_SOURCE_2 : La source de la candidature du candidat numéro 2
        - APP_CANDIDATES_AVAILABILITY_2 : La date de disponibilité du candidat numéro 2
        

        - APP_CANDIDATES_ADDRESS : L'adresse de test
        - APP_CANDIDATES_CITY : La ville de test
        - APP_CANDIDATES_POSTCODE : Le code postal de test

        - APP_CANIDIDATES_QUALIFICATIONS : La liste de qualifications de test et leur date d'obtention 
        - APP_CANIDATES_HELPS_1 : La liste des aides de test numéro 1
        - APP_CANIDATES_HELPS_2 : La liste des aides de test numéro 2
        - APP_CANDIDATES_COOPTEUR : Le coopteur de test (le candidat numéro 1)
        
        Wrong Candidate :
        - APP_CANDIDATES_WRONG_NAME_1 : Nom invalide 
        - APP_CANDIDATES_WRONG_NAME_2 : Nom invalide 
        - APP_CANDIDATES_WRONG_EMAIL_1 : Email invalide
        - APP_CANDIDATES_WRONG_EMAIL_2 : Email invalide
        - APP_CANDIDATES_WRONG_EMAIL_3 : Email invalide
        - APP_CANDIDATES_WRONG_PHONE_1 : Téléphone invalide
        - APP_CANDIDATES_WRONG_PHONE_2 : Téléphone invalide
        
        - APP_CANDIDATES_WRONG_CITY_1 : Ville invalide
        - APP_CANDIDATES_WRONG_CITY_2 : Ville invalide
        - APP_CANDIDATES_WRONG_CITY_3 : Ville invalide
        - APP_CANDIDATES_WRONG_CITY_4 : Ville invalide
        - APP_CANDIDATES_WRONG_POSTCODE_1 : Code postal invalide
        - APP_CANDIDATES_WRONG_POSTCODE_2 : Code postal invalide
        - APP_CANDIDATES_WRONG_POSTCODE_3 : Code postal invalide


        Buttons : 
        - APP_APPLICATIONS_FILTER_MENU_BUTTON_ID : L'identifiant du bouton du menu de filtres
        - APP_APPLICATIONS_SEARCH_MENU_BUTTON_ID : L'identifiant du bouton du menu de recherches
        - APP_APPLICATIONS_FILTER_VALID_BUTTON_ID : L'identifiant du bouton appliquant les filtres à la sélection 
        - APP_APPLICATIONS_SEARCH_VALID_BUTTON_ID : L'identifiant du bouton appliquant la recherche à la sélection
        - APP_APPLICATIONS_FILTER_RESET_BUTTON_ID : L'identifiant du bouton réinitialisant les filtres de la sélection 
        - APP_APPLICATIONS_SEARCH_RESET_BUTTON_ID : L'identifiant du bouton réinitialisant la recherche de la sélection 
    """
    ## COLOR ##
    BLUE  = '\033[94m'
    RED   = '\033[91m'
    GREEN = '\033[92m'
    RESET = '\033[0m'

    SLEEP_TIME   = 0.7
    LOADING_TIME = 2
    WAITED_TIME  = 15

    ## App DATA ##
    APP_URL      = "http://localhost/ypopsi"
    APP_ID       = "test.py"
    APP_PASSWORD = "test123"

    ## APP URL ##
    APP_HOME_PAGE_LINK         = "/index.php"
    APP_CONNEXION_FORM_LINK    = APP_HOME_PAGE_LINK + "?login=get_connexion"
    APP_APPLICATIONS_PAGE_LINK = APP_HOME_PAGE_LINK + "?applications=home"
    APP_PREFERENCES_PAGE_LINK  = APP_HOME_PAGE_LINK + "?preferences=home"

    ## CANDIDATES ##
    APP_CANDIDATES_NAME_1      = "Dupond"
    APP_CANDIDATES_FIRSTNAME_1 = "Jean"
    APP_CANDIDATES_EMAIL_1     = "jean.dupond@diaconat-mulhouse.fr"
    APP_CANDIDATES_PHONE_1     = "06.33.44.55.78"
    APP_CANDIDATES_GENDER_1    = 1

    APP_CANDIDATES_NAME_2      = "Margueritte"
    APP_CANDIDATES_FIRSTNAME_2 = "Catherine"
    APP_CANDIDATES_EMAIL_2     = "catherine.margueritte@diaconat-mulhouse.fr"
    APP_CANDIDATES_PHONE_2     = "07.78.21.55.43"

    APP_CANDIDATES_ADDRESS  = "1 rue de la Prairie"
    APP_CANDIDATES_CITY     = "Prairie-Land"
    APP_CANDIDATES_POSTCODE = "78451"

    APP_CANIDIDATES_QUALIFICATION = [
        {
            "titled": "Baccalauréat général",
            "date"  : "07/09/1992"
        }
    ]
    APP_CANIDIDATES_QUALIFICATIONS = [
        {
            "titled": "Baccalauréat général",
            "date"  : "07/09/1992"
        },
        {
            "titled": "Licence Pro",
            "date"  : "04/09/1995"
        }
    ]  

    APP_CANDIDATES_HELP     = [ "Bourse d'étude" ]
    APP_CANDIDATES_HELPS    = [ "Bourse d'étude", "Prime de cooptation" ]
    APP_CANDIDATES_COOPTEUR = APP_CANDIDATES_NAME_1 + APP_CANDIDATES_FIRSTNAME_1
    
    APP_CANDIDATES_JOB_1 = "AGENT ADMINISTRATIF"
    APP_CANDIDATES_JOB_2 = "AIDE-SOIGNANT"
    
    APP_CANDIDATES_SERVICE_1 = "ACCUEIL INSCRIP ADMISSION"
    APP_CANDIDATES_SERVICE_2 = "MEDECINE"
    
    APP_CANDIDATES_ESTABLISHMENT_1 = "Clinique du Diaconat Roosevelt"
    APP_CANDIDATES_ESTABLISHMENT_2 = "Clinique du Diaconat Colmar"
    
    APP_CANDIDATES_CONTRACT_TYPE_1 = "CDI"
    APP_CANDIDATES_CONTRACT_TYPE_2 = "CDD"
    
    APP_CANDIDATES_SOURCE_1 = "Téléphone"
    APP_CANDIDATES_SOURCE_2 = "Appel Médical"
    
    APP_CANDIDATES_AVAILABILITY_1 = datetime.now().strftime("%d/%m/%Y")
    APP_CANDIDATES_AVAILABILITY_2 = (datetime.now() + relativedelta(months=2)).strftime("%d/%m/%Y")
    
    APP_CANDIDATES_RATING_1 = 1
    APP_CANDIDATES_RATING_2 = 2
    APP_CANDIDATES_RATING_3 = 3
    APP_CANDIDATES_RATING_4 = 4
    APP_CANDIDATES_RATING_5 = 5

    ## WRONG DATA ##
    APP_CANDIDATES_WRONG_NAME_1  = 1
    APP_CANDIDATES_WRONG_NAME_2  = "3doire"
    APP_CANDIDATES_WRONG_NAME_3  = "Ed@ire"
    APP_CANDIDATES_WRONG_EMAIL_1 = "Gregoire"
    APP_CANDIDATES_WRONG_EMAIL_2 = "gregoire.mastuvu@jetevois"
    APP_CANDIDATES_WRONG_EMAIL_3 = "gregoire.mastuvu.fr"
    APP_CANDIDATES_WRONG_PHONE_1 = "06.13.32"
    APP_CANDIDATES_WRONG_PHONE_2 = "06.13.32.45.78.68.25.42"

    APP_CANDIDATES_WRONG_CITY_1     = 1
    APP_CANDIDATES_WRONG_CITY_2     = "1"
    APP_CANDIDATES_WRONG_CITY_3     = "bonj@ur"
    APP_CANDIDATES_WRONG_CITY_4     = "_Pr@!r!e-Land//"
    APP_CANDIDATES_WRONG_POSTCODE_1 = -1
    APP_CANDIDATES_WRONG_POSTCODE_2 = "123456789"
    APP_CANDIDATES_WRONG_POSTCODE_3 = "Salut à tous !"
    
    APP_CANIDIDATES_WRONG_QUALIFICATION_1 = { "titled": "Salut bg", "date"  : "07/09/1992" }
    APP_CANIDIDATES_WRONG_QUALIFICATION_2 = { "titled": "2", "date"  : "04/09/1995" }
    APP_CANIDIDATES_WRONG_QUALIFICATION_3 = { "titled": "Baccalauréat général", "date"  : "09/1992" }
    APP_CANIDIDATES_WRONG_QUALIFICATION_4 = { "titled": "Baccalauréat général", "date"  : "02/05/09/1992" }
    APP_CANIDIDATES_WRONG_QUALIFICATION_5 = { "titled": "Baccalauréat général", "date"  : "205/09/1992" }
    APP_CANIDIDATES_WRONG_QUALIFICATION_6 = { "titled": "Baccalauréat général", "date"  : "30/02/1992" }

    ## MENU BUTTON ##
    APP_APPLICATIONS_FILTER_MENU_BUTTON_ID = "filtrer-bouton"
    APP_APPLICATIONS_SEARCH_MENU_BUTTON_ID = "rechercher-bouton"

    ## VALID BUTTON ##
    APP_APPLICATIONS_FILTER_VALID_BUTTON_ID = "valider-filtre"
    APP_APPLICATIONS_SEARCH_VALID_BUTTON_ID = "valider-recherche"

    ## RESET BUTTON ##
    APP_APPLICATIONS_FILTER_RESET_BUTTON_ID = "reinint-filtre"
    APP_APPLICATIONS_SEARCH_RESET_BUTTON_ID = "reinint-recherche"

    # * CONSTRUCTOR * #
    def __init__(self, test_name):
        """
        Constructeur de la classe TestRunner

        Attributs:
            - test_name : le nom du test 
        """
        self._name = test_name
        
    def connect(self):
        """
        Établit une connexion à l'application Ypopsi avec les identifiants de test.
        """
        driver = webdriver.Chrome()
        
        driver.set_window_size(1700, 1000)
        
        driver.get(self.APP_URL + self.APP_CONNEXION_FORM_LINK)
        time.sleep(self.SLEEP_TIME)

        action_button = driver.find_element(By.ID, "action-button") 
        action_button.click()
        
        time.sleep(self.SLEEP_TIME)

        identifier_input = driver.find_element(By.ID, "identifiant")
        identifier_input.send_keys(self.APP_ID)
        
        password_input = driver.find_element(By.ID, "motdepasse") 
        password_input.send_keys(self.APP_PASSWORD)
        
        password_input.send_keys(Keys.RETURN)
        
        time.sleep(self.SLEEP_TIME)

        return driver

    # * write * #
    def writeName(self):
        """
        Méthode inscrivant le nom du test
        """
        write(f"Exécution du test : {self._name}", self.BLUE, "text")
        
    def writeSuccess(self):
        """
        Méthode publique notifiant la réussite d'un test
        """
        print(f"\n{self.GREEN} Test validé ! {self.RESET}")
        
    def writeFailure(self):
        """
        Méthode publique notifiant la réussite d'un test
        """
        print(f"\n{self.RED} Test échoué !{self.RESET}")
        sys.exit()
        
    def writeError(self, exception, force_exit = True):
        """
        Méthode publlique inscrivant une erreur et arrêtant si besoin l'algorithme

        Args:
            exception (Exception): L'exception à inscrire
            force_exit (Boolean): Le booléen indiquant si le programme doit être arrêter
        """
        print(f"\n{self.RED} Erreur : {str(exception)}.{self.RESET}")
        
        if(force_exit):
            self.writeFailure()

    # * FIND * #
    ## CSS ##
    def find_element_by_id(self, driver, element_id, wait_time = WAITED_TIME):
        """
        Récupère un élément par son identifiant unique.
        
        Paramètres:
            driver (webdriver): L'instance du navigateur
            element_id (str): L'identifiant unique de l'élément
            wait_time (int): Le temps d'attente maximum en secondes
            
        Returns:
            WebElement: L'élément trouvé ou None
        """
        try:
            element = WebDriverWait(driver, wait_time).until(
                EC.presence_of_element_located((By.ID, element_id))
            )
            
            return element
        except Exception as e:
            print(f"{self.RED}Erreur lors de la recherche de l'élément d'identifiant '{element_id}': {str(e)}{self.RESET}")
            return None  
        
    def find_elements_by_css(self, driver, css_selector, wait_time = WAITED_TIME):
        """
        Récupère tous les éléments correspondant à un sélecteur CSS complexe.
        
        Paramètres:
            driver (webdriver): L'instance du navigateur
            css_selector (str): Le sélecteur CSS (ex: '.navbarre .action-section a')
            wait_time (int): Le temps d'attente maximum en secondes
            
        Returns:
            list: Liste des éléments trouvés
        """
        try:
            elements = WebDriverWait(driver, wait_time).until(
                EC.presence_of_all_elements_located((By.CSS_SELECTOR, css_selector))
            )
            
            if(elements):
                return elements
            else:
                raise Exception("Aucun élément trouvé")
        except Exception as e:
            self.writeError(e)
            return None 
            
    def find_element_by_css(self, driver, css_selector, wait_time = WAITED_TIME):
        """
        Récupère le premier élément correspondant à un sélecteur CSS complexe.
        
        Paramètres:
            driver (webdriver): L'instance du navigateur
            css_selector (str): Le sélecteur CSS (ex: '.navbarre .action-section a')
            wait_time (int): Le temps d'attente maximum en secondes
            
        Returns:
            WebElement: Le premier élément trouvé ou None
        """
        try:
            element = WebDriverWait(driver, wait_time).until(
                EC.presence_of_element_located((By.CSS_SELECTOR, css_selector))
            )
            return element
        except Exception as e:
            print(f"{self.RED}Erreur lors de la recherche de l'élément '{css_selector}': {str(e)}{self.RESET}")
            return None       

    ## CLASS ##
    def find_elements_by_class(self, driver, class_name, wait_time = WAITED_TIME):
        """
        Récupère tous les éléments ayant une classe spécifique.
        
        Paramètres:
            driver (webdriver): L'instance du navigateur
            class_name (str): Le nom de la classe CSS à rechercher
            wait_time (int): Le temps d'attente maximum en secondes
            
        Returns:
            list: Liste des éléments trouvés
        """
        try:
            elements = WebDriverWait(driver, wait_time).until(
                EC.presence_of_all_elements_located((By.CLASS_NAME, class_name))
            )
            
            return elements
        except Exception as e:
            print(f"{self.RED}Erreur lors de la recherche des éléments de classe '{class_name}': {str(e)}{self.RESET}")
            return []
        
    def find_element_by_class(self, driver, class_name, wait_time = WAITED_TIME):
        """
        Récupère le premier élément ayant une classe spécifique.
        
        Paramètres:
            driver (webdriver): L'instance du navigateur
            class_name (str): Le nom de la classe CSS à rechercher
            wait_time (int): Le temps d'attente maximum en secondes
            
        Returns:
            WebElement: Le premier élément trouvé ou None
        """
        try:
            element = WebDriverWait(driver, wait_time).until(
                EC.presence_of_element_located((By.CLASS_NAME, class_name))
            )
            return element
        except Exception as e:
            print(f"{self.RED}Erreur lors de la recherche de l'élément de classe '{class_name}': {str(e)}{self.RESET}")
            return None
        
    ## FILTER ##
    def find_element_by_text(self, elements, text_content):
        """
        Trouve le premier élément dont le texte contient la chaîne spécifiée.
        
        Paramètres:
            elements (list): Liste d'éléments WebElement à filtrer
            text_content (str): Texte à rechercher dans le contenu
            
        Returns:
            WebElement: Premier élément correspondant ou None
        """
        try:
            for element in elements:
                if text_content in element.text:
                    return element
                
            print(f"{self.RED}Aucun élément trouvé avec le texte '{text_content}'{self.RESET}")
            
            return None
        except Exception as e:
            print(f"{self.RED}Erreur lors de la recherche par texte '{text_content}': {str(e)}{self.RESET}")
            return None
        
    def find_element_by_href(self, elements, href_content):
        """
        Trouve le premier élément dont l'attribut href contient la chaîne spécifiée.
        
        Paramètres:
            elements (list): Liste d'éléments WebElement à filtrer
            href_content (str): Texte à rechercher dans l'attribut href
            
        Returns:
            WebElement: Premier élément correspondant ou None
        """
        try:
            for element in elements:
                href = element.get_attribute('href')
                if href and href_content in href:
                    return element
                
            print(f"{self.RED}Aucun élément trouvé avec href contenant '{href_content}'{self.RESET}")
            
            return None
        except Exception as e:
            print(f"{self.RED}Erreur lors de la recherche par href '{href_content}': {str(e)}{self.RESET}")
            return None
    
    # * NAVIGATION * #
    ## MENU BARRE ##
    def goToHomePage(self, driver):
        """
        Navigue vers la section Applications en trouvant le bon lien dans la navbar
        """
        elements = self.find_elements_by_css(driver, ".navbarre .action-section a")
        
        if(elements):
            applications_link = self.find_element_by_href(elements, self.APP_HOME_PAGE_LINK)
    
            if applications_link:
                applications_link.click()  
            else:
                raise Exception("erreur lors de la navigation vers la page d'accueil - bouton home introuvable")
        else:
            raise Exception("erreur lors de la navigation vers la page d'accueil - aucun bouton détecté")
            
    def goToApplicationsPage(self, driver):
        """
        Navigue vers la section Applications en trouvant le bon lien dans la navbar
        """ 
        elements = self.find_elements_by_css(driver, ".navbarre .action-section a")
    
        if(elements):
            applications_link = self.find_element_by_href(elements, self.APP_APPLICATIONS_PAGE_LINK)
            
            if applications_link:
                applications_link.click()
                time.sleep(self.SLEEP_TIME)
            else:
                raise Exception("erreur lors de la navigation vers la page candidatures - bouton candidature introuvable")
        else:
            raise Exception("erreur lors de la navigation vers la page candidatures - aucun bouton détecté")
            
    def goToPreferencesPage(self, driver):
        """
        Navigue vers la section Applications en trouvant le bon lien dans la navbar
        """
        elements = self.find_elements_by_css(driver, ".navbarre .action-section a")
        applications_link = self.find_element_by_href(elements, self.APP_PREFERENCES_PAGE_LINK)
        
        if applications_link:
            applications_link.click()
        
    ## LIST MENU ##
    def clickOnFilter(self, driver):
        """
        Méthode ouvrant la panneaux de filtres
        """
        element = driver.find_element(By.ID, self.APP_APPLICATIONS_FILTER_MENU_BUTTON_ID)
        if(element):
            element.click()   

    def clickOnSearch(self, driver):
        """
        Méthode ouvrant la panneaux de recherches
        """
        element = driver.find_element(By.ID, self.APP_APPLICATIONS_SEARCH_MENU_BUTTON_ID)
        if(element):
            element.click()
            
    ## LIST MANIP ##
    def clickOnFirstElmt(self, driver):
        item = self.find_element_by_css(driver, ".liste_items .table-wrapper table tbody tr")
        
        item.click()
        
    # * INPUT * #
    def setInputValue(self, input, value):
        """
        Rempli un champ de formulaire avec une valeur donnée
        """
        if(input):
            input.clear()
            
            if(value):
                input.send_keys(value)
            else:
                raise Exception("Aucune valeur à saisir")
        else:
            raise Exception("Aucun input fourni")
        
    # * OTHERS * #
    def linkTest(self, driver, expected_url_pattern: str): 
        current_url = driver.current_url
        
        print(f"URL actuelle : {current_url}")
        
        print(f"URL recherchée : {expected_url_pattern}")
        
        if not re.match(expected_url_pattern, current_url):
            raise Exception(f"L'URL est incorrect : {current_url}")