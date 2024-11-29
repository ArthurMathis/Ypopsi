import sys
import os
sys.path.append(os.path.dirname(os.path.dirname(os.path.dirname(os.path.dirname(__file__)))))

from tests.selenium.run_test import TestRunner

class ConnexionTestRunner(TestRunner):
    def main(self):
        print(f"{self.BLEU}=== Début des tests de connexion ==={self.RESET}")
        
        # Test de connexion réussie
        self.run_test("Test de connexion réussie", "tests/selenium/connexion/connect_success.py")
        
        # Test de connexion échouée
        self.run_test("Test de connexion échouée", "tests/selenium/connexion/connect_failure.py")
        
        # Test de déconnexion
        self.run_test("Test de déconnexion", "tests/selenium/connexion/disconnect.py")
        
        print(f"\n{self.BLEU}=== Fin des tests de connexion ==={self.RESET}")

if __name__ == "__main__":
    runner = ConnexionTestRunner()
    runner.main()