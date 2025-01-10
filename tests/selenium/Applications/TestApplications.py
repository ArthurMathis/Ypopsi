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
        self.connect()
        self.goToApplicationsPage()

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
        element = self.find_element_by_css(driver, ".option_barre article a.action_button:not(.reverse_color)")
        if element:
            element.click()