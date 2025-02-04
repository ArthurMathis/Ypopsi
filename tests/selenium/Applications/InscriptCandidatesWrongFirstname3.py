import os
import sys
import time
import re

from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import Select

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from TestApplications import TestApplications

class InscriptCandidatesWrongFirstname3(TestApplications):
    """
    Classe de test pour l'inscription d'un candidat.
    Hérite de TestApplications pour utiliser ses fonctionnalités.
    """
    
    def __init__(self):
        """
        Initialise le test avec un nom descriptif
        """
        super().__init__("Test d'inscription d'un candidat - prénom invalide 3")

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
                self.APP_CANDIDATES_WRONG_NAME_3,
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
                self.APP_CANDIDATES_SERVICE_1,
                self.APP_CANDIDATES_ESTABLISHMENT_1, 
                self.APP_CANDIDATES_CONTRACT_TYPE_1, 
                self.APP_CANDIDATES_AVAILABILITY_1, 
                self.APP_CANDIDATES_SOURCE_1
            )    
            
            time.sleep(self.LOADING_TIME)
            
            # On vérifie l'URL
            expected_url_pattern = r"http://localhost/ypopsi/index.php\?candidates=\d+"
            current_url = driver.current_url

            if re.match(expected_url_pattern, current_url):
                self.writeError(e, True)
            else:
                raise Exception(f"L'URL est incorrecte : {current_url}")
            
        except Exception as e:
            self.writeSuccess()
            
        finally:
            if driver:
                driver.quit()

if __name__ == "__main__":
    test = InscriptCandidatesWrongFirstname3()
    test.run()