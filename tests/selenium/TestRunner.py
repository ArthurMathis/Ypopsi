import sys
import time

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

class TestRunner:
    """
    Classe développée pour exécuter des tests de fonctionnalités sur l'application Ypopsi.
    Cette classe utilise Selenium WebDriver pour automatiser les tests d'interface utilisateur.

    Attributs:
        - BLUE : Code couleur pour les messages d'information
        - RED : Code couleur pour les messages d'échec
        - GREEN : Code couleur pour les messages de succès
        - SLEEP_TIME : Le temps de pause (en secondes) entre les actions
        - APP_URL : L'adresse de l'application Ypopsi
        - APP_ID : L'identifiant de connexion pour les tests
        - APP_PASSWORD : Le mot de passe de la session de test
    """
    ## COLOR ##
    BLUE  = '\033[94m'
    RED   = '\033[91m'
    GREEN = '\033[92m'
    RESET = '\033[0m'

    SLEEP_TIME = 0.5

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
    APP_CANDIDATES_NAME_1     = "Dupond"
    APP_CANDIDATES_FISTNAME_1 = "Jean"
    APP_CANDIDATES_EMAIL_1    = "jean.dupond@diaconat-mulhouse.fr"
    APP_CANDIDATES_PHONE_1    = "06.33.44.55.78"

    APP_CANDIDATES_NAME_2     = "Margueritte"
    APP_CANDIDATES_FISTNAME_2 = "Catherine"
    APP_CANDIDATES_EMAIL_2    = "catherine.margueritte@diaconat-mulhouse.fr"
    APP_CANDIDATES_PHONE_2    = "07.78.21.55.43"

    ## WRONG DATA ##
    APP_CANDIDATES_WRONG_NAME_1  = 1
    APP_CANDIDATES_WRONG_NAME_1  = "3doire"
    APP_CANDIDATES_WRONG_EMAIL_1 = "Gregoire"
    APP_CANDIDATES_WRONG_EMAIL_2 = "gregoire.mastuvu@jetevois"
    APP_CANDIDATES_WRONG_EMAIL_3 = "gregoire.mastuvu.fr"
    APP_CANDIDATES_WRONG_PHONE_1 = "06.13.32"
    APP_CANDIDATES_WRONG_PHONE_2 = "06.13.32.45.78.68.25.42"

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
        driver.get(self.APP_URL + self.APP_CONNEXION_FORM_LINK)
        time.sleep(self.SLEEP_TIME)

        action_button = driver.find_element(By.ID, "action-button") 
        action_button.click()
        time.sleep(0.7)

        identifier_input = driver.find_element(By.ID, "identifiant")
        identifier_input.send_keys(self.APP_ID)
        password_input = driver.find_element(By.ID, "motdepasse") 
        password_input.send_keys(self.APP_PASSWORD)
        password_input.send_keys(Keys.RETURN)

        return driver

    # * WRITTE * #
    def writteName(self):
        """
        Méthode inscrivant le nom du test 
        """
        print(f"\n{self.BLUE}=== Exécution du test : {self._name} ==={self.RESET}")
    def writteSuccess(self):
        """
        Méthode publique notifiant la réussite d'un test
        """
        print(f"\n{self.GREEN} Test validé ! {self.RESET}")
    def writteFailure(self):
        """
        Méthode publique notifiant la réussite d'un test
        """
        print(f"\n{self.RED} Test échoué !{self.RESET}")
        sys.exit()

    # * FIND * #
    ## CSS ##
    def find_elements_by_css(self, driver, css_selector, wait_time=10):
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
            return elements
        except Exception as e:
            print(f"{self.RED}Erreur lors de la recherche des éléments '{css_selector}': {str(e)}{self.RESET}")
            return []
    def find_element_by_css(self, driver, css_selector, wait_time=10):
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
    def find_elements_by_class(self, driver, class_name, wait_time=10):
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
    def find_element_by_class(self, driver, class_name, wait_time=10):
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
        applications_link = self.find_element_by_href(elements, self.APP_HOME_PAGE_LINK)
        
        if applications_link:
            applications_link.click()
    def goToApplicationsPage(self, driver):
        """
        Navigue vers la section Applications en trouvant le bon lien dans la navbar
        """
        elements = self.find_elements_by_css(driver, ".navbarre .action-section a")
        applications_link = self.find_element_by_href(elements, self.APP_APPLICATIONS_PAGE_LINK)
        
        if applications_link:
            applications_link.click()
    def goToPreferencesPage(self, driver):
        """
        Navigue vers la section Applications en trouvant le bon lien dans la navbar
        """
        elements = self.find_elements_by_css(driver, ".navbarre .action-section a")
        applications_link = self.find_element_by_href(elements, self.APP_PREFERENCES_PAGE_LINK)
        
        if applications_link:
            applications_link.click()