import os
import sys
import time
import re

from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import Select

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from TestApplications import TestApplications

class InscriptCandidatesWrongEmail1(TestApplications):
    """
    Classe de test pour l'inscription d'un candidat.
    Hérite de TestApplications pour utiliser ses fonctionnalités.
    """
    
    def __init__(self):
        """
        Initialise le test avec un nom descriptif
        """
        super().__init__("Test d'inscription d'un candidat - email invalide 1")

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
                self.APP_CANDIDATES_WRONG_EMAIL_1, 
                self.APP_CANDIDATES_PHONE_1, 
                self.APP_CANDIDATES_ADDRESS, 
                self.APP_CANDIDATES_CITY, 
                self.APP_CANDIDATES_POSTCODE
            )
            
            time.sleep(self.LOADING_TIME)
            
            inscript_url = "http://localhost/ypopsi/index.php?applications=input-applications"
            current_url = driver.current_url
            
            if inscript_url == current_url:
                self.writeError(Exception("Url incorrect"), True)
            else:
                raise Exception()
            
        except Exception as e:
            self.writeSuccess()
            
        finally:
            if driver:
                driver.quit()

if __name__ == "__main__":
    test = InscriptCandidatesWrongEmail1()
    test.run()