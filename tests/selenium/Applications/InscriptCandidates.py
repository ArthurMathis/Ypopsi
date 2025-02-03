import os
import sys
import time

from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import Select

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from TestApplications import TestApplications

class InscriptCandidates(TestApplications):
    """
    Classe de test pour l'inscription d'un candidat.
    Hérite de TestCandidates pour utiliser ses fonctionnalités.
    """
    
    def __init__(self):
        """
        Initialise le test avec un nom descriptif
        """
        super().__init__("Test d'inscription d'un candidat")

    def run(self):
        """
        Exécute le test d'inscription d'un candidat
        """
        self.writeName()

        print("On lance le programme")
        
        try:    
            driver = self.start()
        
            if driver is None:
                raise Exception("Le driver n'a pas pu être initialisé.")

            self.clickOnCandidatesInput(driver) 
            
            
            i_name = self.find_element_by_id(driver, "nom")
            self.setInputValue(i_name, self.APP_CANDIDATES_NAME_1)
            
            i_firstname = self.find_element_by_id(driver, "prenom")
            self.setInputValue(i_firstname, self.APP_CANDIDATES_FISTNAME_1)
            
            # i_gender = Select(self.find_element_by_id(driver, "genre"))
            # i_gender.select_by_value(self.APP_CANDIDATES_GENDER_1)
            
            i_email = self.find_element_by_id(driver, "email")
            self.setInputValue(i_email, self.APP_CANDIDATES_EMAIL_1)
            
            i_phone = self.find_element_by_id(driver, "phone")
            self.setInputValue(i_phone, self.APP_CANDIDATES_PHONE_1)
            
            
            time.sleep(20)
            
            self.writeSuccess()
            
        except Exception as e:
            self.writeError(e, True)
            
        finally:
            if driver:
                driver.quit()

if __name__ == "__main__":
    test = InscriptCandidates()
    test.run()

