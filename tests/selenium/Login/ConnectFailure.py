import os
import sys
import time

from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from TestRunner import TestRunner

class TestConnectFailure(TestRunner):
    """
    Classe de test pour l'inscription à un entretien.
    Hérite de TestRunner pour utiliser ses fonctionnalités.
    """
    
    # * CONSTRUCTOR * #
    def __init__(self):
        """
        Initialise le test avec un nom descriptif
        """
        super().__init__("Test de sécurité de la connexion à l'application")

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

        # Remplissage du formulaire de connexion
        identifier_input = driver.find_element(By.ID, "identifiant")
        identifier_input.send_keys(self.APP_ID)
        password_input = driver.find_element(By.ID, "motdepasse") 
        password_input.send_keys("random password")
        password_input.send_keys(Keys.RETURN)

        return driver

    def run(self):
        """
        Exécute le test d'inscription à un entretien
        """
        self.writeName()
        driver = None
        
        try:
            driver = self.connect()
            time.sleep(self.SLEEP_TIME)
            
            self.writeFailure()
            
        except Exception as e:
            self.writeSuccess()
            
        finally:
            if driver:
                driver.quit()

if __name__ == "__main__":
    test = TestConnectFailure()
    test.run()
