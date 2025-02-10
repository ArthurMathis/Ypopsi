import os
import sys
import time

from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys

current_dir = os.path.dirname(os.path.abspath(__file__))

parent_dir = os.path.dirname(current_dir)

sys.path.append(parent_dir)

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
        self.writeName()
        driver = None
        
        try:
            driver = self.connect()
            time.sleep(self.SLEEP_TIME)
            
            self.writeSuccess()
            
        except Exception as e:
            self.writeFailure()
            print(f"Erreur : {str(e)}")
            
        finally:
            if driver:
                driver.quit()

if __name__ == "__main__":
    test = TestConnect()
    test.run()
