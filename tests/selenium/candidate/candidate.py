import sys
import os
sys.path.append(os.path.dirname(os.path.dirname(os.path.dirname(os.path.dirname(__file__)))))

from tests.selenium.run_test import TestRunner

class CandidateTestRunner(TestRunner):
    def main(self):
        print(f"{self.BLEU}=== Début des tests de manipulation d'un candidat ==={self.RESET}")
        
        # Test de connexion réussie
        self.run_test("Test d'inscription d'un rendez-vous", "tests/selenium/candidate/inscript_meeting_success.py")
        self.run_test("Test d'inscription d'un rendez-vous", "tests/selenium/candidate/inscript_meeting_failure.py")
        
        print(f"\n{self.BLEU}=== Fin des tests de connexion ==={self.RESET}")

if __name__ == "__main__":
    runner = CandidateTestRunner()
    runner.main()