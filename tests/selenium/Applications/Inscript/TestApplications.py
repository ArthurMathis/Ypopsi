import os
import sys
import time

from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import Select

sys.path.append(os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__)))))

from TestRunner import TestRunner

class TestApplications(TestRunner):
    QUALIFICATIONS_SECTION_ID = "diplome-section"
    QUALIFICATIONS_INPUT_STR_ID = "diplome-"
    QUALIFICATIONS_INPUT_DATE_ID = "diplomeDate-"
    
    NOTIFICATION_CONFIRM_BUTTON_ID = "swal2-confirm"
    
    HELPS_SECTION_ID = "aide-section"
    HELPS_INPUT_NAME = "aide[]"
    
    VISIT_ID = "visite_medicale"
    
    def start(self):
        """
        Méthode préparant l'application pour le test

        Etapes:
            1. Connexion à l'application
            2. Navigation vers le menu candidatures
        """
        driver = self.connect()
        
        self.goToApplicationsPage(driver)
        
        return driver

    # * NAVIGATION * #
    def clickOnListOfApplications(self, driver):
        """
        Navigue vers la section Applications en trouvant le bon lien dans la navbar
        """
        element = self.find_element_by_css(driver, ".option_barre article a.action_button.reverse_color")
        if element:
            element.click()
            
    def clickOnListOfCandidates(self, driver):
        """
        Navigue vers la section Applications en trouvant le bon lien dans la navbar
        """
        element = self.find_element_by_css(driver, ".option_barre article a.action_button")        
        if element:
            element.click()
            
    def clickOnCandidatesInput(self, driver):
        """
        Navigue vers la section Applications en trouvant le bon lien dans la navbar
        """
        try:
            elements = self.find_elements_by_css(driver, ".action_button")
            
            if elements:
                action_link = self.find_element_by_text(elements, "Nouvelle candidature")
                
                if action_link:
                    action_link.click()
                    time.sleep(self.SLEEP_TIME)
                else:
                    raise Exception("Aucun bouton 'Nouvelle candidature' trouvé")
            else:
                raise Exception("Aucun bouton trouvé")
            
        except Exception as e:
            print(f"Erreur lors de la recherche des éléments '.action_button': {str(e)}")
        
    # * FORM * #
    def setCandidateForm(self, driver, name, firstanme, email = None, phone = None, address = None, city = None, postcode = None):
        i_name = self.find_element_by_id(driver, "nom")
        self.setInputValue(i_name, name)
        
        i_firstname = self.find_element_by_id(driver, "prenom")
        self.setInputValue(i_firstname, firstanme)
        
        if(email):
            i_email = self.find_element_by_id(driver, "email")
            self.setInputValue(i_email, email)
        
        if(phone):
            i_phone = self.find_element_by_id(driver, "telephone")
            self.setInputValue(i_phone, phone) 
        
        if(address):
            i_address = self.find_element_by_id(driver, "adresse")
            self.setInputValue(i_address, address)
        
        if(city):
            i_city = self.find_element_by_id(driver, "ville")
            self.setInputValue(i_city, city)
        
        if(postcode):
            i_postcode = self.find_element_by_id(driver, "code-postal")
            self.setInputValue(i_postcode, postcode)
        
        submit = self.find_element_by_css(driver, "button[type='submit']")
        submit.click()
        
    def valideNotification(self, driver): 
        valid_btn = self.find_element_by_class(driver, "swal2-confirm")
        valid_btn.click()
        
    def setApplicationForm(self, driver, job, service, establishment, contract_type, availability, source):
        i_poste = self.find_element_by_id(driver, "poste")
        self.setInputValue(i_poste, job)
        
        if(service):
            i_service = self.find_element_by_id(driver, "service")
            self.setInputValue(i_service, service)
        
        if(establishment):
            i_establishment = self.find_element_by_id(driver, "etablissement")
            self.setInputValue(i_establishment, establishment)
            
        if(contract_type):
            i_ctype = self.find_element_by_id(driver, "type_de_contrat")
            self.setInputValue(i_ctype, contract_type)
        
        i_availability = self.find_element_by_id(driver, "disponibilite")
        self.setInputValue(i_availability, availability)
        
        i_source = self.find_element_by_id(driver, "source")
        self.setInputValue(i_source, source)
        
        # Click pour fermer les autocomp
        form = self.find_element_by_css(driver, "form")
        form.click()
        
        second_submit = self.find_element_by_css(driver, "button[type='submit']")
        second_submit.click()
        
    def setQualifications(self, driver, qualifications: list):
        section = self.find_element_by_id(driver, self.QUALIFICATIONS_SECTION_ID)
        button = self.find_element_by_class(section, "form_button")
        
        for index, obj in enumerate(qualifications):
            button.click()
            
            time.sleep(self.SLEEP_TIME)
            
            self.valideNotification(driver)
            
            time.sleep(self.SLEEP_TIME)
            
            str_id = self.QUALIFICATIONS_INPUT_STR_ID + str(index + 1)
            str_input = self.find_element_by_id(section, str_id)
            
            self.setInputValue(str_input, obj['titled'])
            
            date_id = self.QUALIFICATIONS_INPUT_DATE_ID + str(index + 1)
            date_input = self.find_element_by_id(driver, date_id)
            
            self.setInputValue(date_input, obj['date'])
            
    def setHelps(self, driver, helps: list):
        section = self.find_element_by_id(driver, self.HELPS_SECTION_ID)
        if not section:
            raise Exception(f"Section with ID '{self.HELPS_SECTION_ID}' not found")

        button = self.find_element_by_class(section, "form_button")
        if not button:
            raise Exception("Button with class 'form_button' not found in helps section")
        
        for obj in helps:
            button.click()
            
            time.sleep(self.SLEEP_TIME)
            
            self.valideNotification(driver)
            
            time.sleep(self.SLEEP_TIME)
            
        helps_input = self.find_element_by_css(section, "select")
        
        print("Liste des inputs : " + str(helps_input))
        
        for index, obj in enumerate(helps):
            select_element = Select(helps_input)
            select_element.select_by_visible_text(helps[index])           
        
    def setVisit(self, driver, date: str): 
        input = self.find_element_by_id(driver, self.VISIT_ID)
        
        self.setInputValue(input, date)