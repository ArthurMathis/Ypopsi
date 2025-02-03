import os
import sys
import time

from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from TestRunner import TestRunner

class TestApplications(TestRunner):
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