import os
import sys
import time

from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from TestRunner import TestRunner
from Candidates.TestCandidates import TestCandidates

class InscriptCandidates(TestCandidates):
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
        self.writteName()
        driver = None
        
        try:
            driver = self.start()
            self.clickOnCandidatesInput()
            time.sleep(self.SLEEP_TIME)
            
            # TODO: Ajouter les étapes pour l'inscription d'un candidat
            
            self.writteSuccess()
            
        except Exception as e:
            self.writteFailure()
            print(f"Erreur : {str(e)}")
            
        finally:
            if driver:
                driver.quit()

if __name__ == "__main__":
    test = InscriptCandidates()
    test.run()

