import os
import sys
import time
import re

from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import Select

current_dir = os.path.dirname(os.path.abspath(__file__))

right_dir             = os.path.dirname(current_dir)
inscript_dir          = os.path.dirname(right_dir)

sys.path.append(inscript_dir)

from TestApplications import TestApplications

class InscriptCandidatesWithoutService(TestApplications):
    """
    Classe de test pour l'inscription d'un candidat.
    Hérite de TestApplications pour utiliser ses fonctionnalités.
    """
    
    def __init__(self):
        """
        Initialise le test avec un nom descriptif
        """
        super().__init__("Test d'inscription d'un candidat - sans service")

    def run(self):
        """
        Exécute le test d'inscription d'un candidat
        """
        self.writeName()

        try:    
            driver = self.start()
            if driver is None:
                raise Exception("Le driver n'a pas pu être initialisé.")

            self.clickOnCandidatesInput(driver) 
            
            # * CANDIDATE * #
            self.setCandidateForm(
                driver, 
                self.APP_CANDIDATES_NAME_1, 
                self.APP_CANDIDATES_FIRSTNAME_1,
                self.APP_CANDIDATES_EMAIL_1, 
                self.APP_CANDIDATES_PHONE_1, 
                self.APP_CANDIDATES_ADDRESS, 
                self.APP_CANDIDATES_CITY, 
                self.APP_CANDIDATES_POSTCODE
            )
            
            # * APPLICATION * #   
            self.setApplicationForm(
                driver, 
                self.APP_CANDIDATES_JOB_1, 
                None,
                None, 
                self.APP_CANDIDATES_CONTRACT_TYPE_1, 
                self.APP_CANDIDATES_AVAILABILITY_1, 
                self.APP_CANDIDATES_SOURCE_1
            )    
            
            time.sleep(self.LOADING_TIME)
            
            # On vérifie l'URL
            expected_url_pattern = r"http://localhost/ypopsi/index.php\?candidates=\d+"
            current_url = driver.current_url

            if re.match(expected_url_pattern, current_url):
                self.writeSuccess()
            else:
                raise Exception(f"L'URL est incorrect : {current_url}")
            
        except Exception as e:
            self.writeError(e, True)
            
        finally:
            if driver:
                driver.quit()

if __name__ == "__main__":
    test = InscriptCandidatesWithoutService()
    test.run()
