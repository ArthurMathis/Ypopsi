import os
import sys
import time

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from TestRunner import TestApplications

class TestCandidates(TestApplications):
    """
    Classe destinée aux tests des fonctionnalités de manipulations de candidats      
    """
    
    def start(self):
        """
        Méthode préparant l'application pour le test

        Etapes:
            1. Connexion à l'application
            2. Navigation vers le menu candidatures

        Returns:
            Driver
        """
        driver = self.connect()

        self.goToApplicationsPage()
        time.sleep(self.SLEEP_TIME)

        return driver