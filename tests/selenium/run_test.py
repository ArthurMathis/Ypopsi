import subprocess
import time
import os

class TestRunner:
    # Codes couleur ANSI
    BLEU = '\033[94m'
    ROUGE = '\033[91m'
    VERT = '\033[92m'
    BLANC = '\033[97m'
    RESET = '\033[0m'

    def run_test(self, test_name, script_path):
        print(f"\n{self.BLEU}=== Exécution du test : {test_name} ==={self.RESET}")
        try:
            env = os.environ.copy()
            env["PYTHONPATH"] = os.path.dirname(os.path.dirname(os.path.dirname(__file__)))
            subprocess.run(['python', script_path], check=True, env=env)
        except subprocess.CalledProcessError as e:
            print(f"Erreur lors de l'exécution de {test_name}: {str(e)}")

def main():
    runner = TestRunner()
    print(f"{TestRunner.BLEU}=== Début des tests Selenium ==={TestRunner.RESET}")
    
    # Tests de connexion/déconnexion
    runner.run_test("Tests de connexion et déconnexion", "tests/selenium/connexion/connect.py")
    
    print(f"\n{TestRunner.BLEU}=== Fin des tests Selenium ==={TestRunner.RESET}")

if __name__ == "__main__":
    main()