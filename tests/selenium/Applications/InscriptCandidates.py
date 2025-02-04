import os
import sys
import time
import re

from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import Select

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from TestApplications import TestApplications

class InscriptCandidates(TestApplications):
    """
    Classe de test pour l'inscription d'un candidat.
    Hérite de TestApplications pour utiliser ses fonctionnalités.
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

        try:    
            driver = self.start()
            if driver is None:
                raise Exception("Le driver n'a pas pu être initialisé.")

            self.clickOnCandidatesInput(driver) 
            
            
            # * CANDIDATE * #
            
            i_name = self.find_element_by_id(driver, "nom")
            self.setInputValue(i_name, self.APP_CANDIDATES_NAME_1)
            
            i_firstname = self.find_element_by_id(driver, "prenom")
            self.setInputValue(i_firstname, self.APP_CANDIDATES_FISTNAME_1)
            
            i_gender = Select(self.find_element_by_id(driver, "genre"))
            i_gender.select_by_value(self.APP_CANDIDATES_GENDER_1)
            
            i_email = self.find_element_by_id(driver, "email")
            self.setInputValue(i_email, self.APP_CANDIDATES_EMAIL_1)
            
            i_phone = self.find_element_by_id(driver, "telephone")
            self.setInputValue(i_phone, self.APP_CANDIDATES_PHONE_1) 
            
            i_address = self.find_element_by_id(driver, "adresse")
            self.setInputValue(i_address, self.APP_CANDIDATES_ADDRESS)
            
            i_city = self.find_element_by_id(driver, "ville")
            self.setInputValue(i_city, self.APP_CANDIDATES_CITY)
            
            i_postcode = self.find_element_by_id(driver, "code-postal")
            self.setInputValue(i_postcode, self.APP_CANDIDATES_POSTCODE)
            
            submit = self.find_element_by_css(driver, "button[type='submit']")
            submit.click()
            
            # * APPLICATION * #       
            
            i_poste = self.find_element_by_id(driver, "poste")
            self.setInputValue(i_poste, self.APP_CANDIDATES_JOB_1)
            
            i_service = self.find_element_by_id(driver, "service")
            self.setInputValue(i_service, self.APP_CANDIDATES_SERVICE_1)
            
            i_establishment = self.find_element_by_id(driver, "etablissement")
            self.setInputValue(i_establishment, self.APP_CANDIDATES_ESTABLISHMENT_1)
            
            i_ctype = self.find_element_by_id(driver, "type_de_contrat")
            self.setInputValue(i_ctype, self.APP_CANDIDATES_CONTRACT_TYPE_1)
            
            i_availability = self.find_element_by_id(driver, "disponibilite")
            self.setInputValue(i_availability, self.APP_CANDIDATES_AVAILABILITY_1)
            
            i_source = self.find_element_by_id(driver, "source")
            self.setInputValue(i_source, self.APP_CANDIDATES_SOURCE_1)
            
            # Click pour fermer les autocomp
            form = self.find_element_by_css(driver, "form")
            form.click()
            
            second_submit = self.find_element_by_css(driver, "button[type='submit']")
            second_submit.click()
            
            time.sleep(self.LOADING_TIME)
            
            # On vérifie l'URL
            expected_url_pattern = r"http://localhost/ypopsi/index.php\?candidates=\d+"
            current_url = driver.current_url

            if re.match(expected_url_pattern, current_url):
                self.writeSuccess()
            else:
                raise Exception(f"L'URL est incorrecte : {current_url}")
            
        except Exception as e:
            self.writeError(e, True)
            
        finally:
            if driver:
                driver.quit()

if __name__ == "__main__":
    test = InscriptCandidates()
    test.run()
