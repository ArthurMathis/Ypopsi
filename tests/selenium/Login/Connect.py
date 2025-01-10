import os
import sys
import time

from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from TestRunner import TestRunner

class TestConnect(TestRunner):
    """
    Classe de test pour l'inscription à un entretien.
    Hérite de TestRunner pour utiliser ses fonctionnalités.
    """
    
    # * CONSTRUCTOR * #
    def __init__(self):
        """
        Initialise le test avec un nom descriptif
        """
        super().__init__("Test de connexion à l'application")

    def run(self):
        """
        Exécute le test d'inscription à un entretien
        """
        self.writteName()
        driver = None
        
        try:
            driver = self.connect()
            time.sleep(self.SLEEP_TIME)
            
            self.writteSuccess()
            
        except Exception as e:
            self.writteFailure()
            print(f"Erreur : {str(e)}")
            
        finally:
            if driver:
                driver.quit()

if __name__ == "__main__":
    test = TestConnect()
    test.run()
