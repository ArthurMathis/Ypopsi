import os
import sys
import time

from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from TestRunner import TestRunner

class TestApplications(TestRunner):
    ## CANDIDATES DATA ##
    APP_CANDIDATES_ADDRESS  = "1 rue de la Prairie"
    APP_CANDIDATES_CITY     = "Prairie-Land"
    APP_CANDIDATES_POSTCODE = "78451"

    APP_CANIDIDATES_QUALIFICATIONS = [
        {
            "titled": "Baccalauréat général",
            "date"  : "07/09/1992"
        },
        {
            "titled": "Licence Pro",
            "date"  : "04/09/1995"
        }
    ]  

    APP_CANIDATES_HELPS_1 = ["Bouse d'étude"]  
    APP_CANIDATES_HELPS_2 = ["Bouse d'étude", "Prime de cooptation"]
    APP_CANDIDATES_COOPTEUR =  TestRunner.APP_CANDIDATES_NAME_1 + TestRunner.APP_CANDIDATES_FISTNAME_1

    ## WRONG DATA ##
    APP_CANDIDATES_WRONG_CITY_1 = 1
    APP_CANDIDATES_WRONG_CITY_2 = "1"
    APP_CANDIDATES_WRONG_CITY_3 = "bonj@ur"
    APP_CANDIDATES_WRONG_CITY_4 = "_Prairie-Land"
    APP_CANDIDATES_WRONG_POSTCODE_1 = -1
    APP_CANDIDATES_WRONG_POSTCODE_2 = "123456789"
    APP_CANDIDATES_WRONG_POSTCODE_3 = "Salut à tous !"

    def start(self):
        """
        Méthode préparant l'application pour le test

        Etapes:
            1. Connexion à l'application
            2. Navigation vers le menu candidatures
        """
        self.connect()
        self.goToApplicationsPage()