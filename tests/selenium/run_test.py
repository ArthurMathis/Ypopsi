import subprocess
import time
import os

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

class TestRunner:
    # Codes couleur ANSI
    BLEU = '\033[94m'
    ROUGE = '\033[91m'
    VERT = '\033[92m'
    BLANC = '\033[97m'
    RESET = '\033[0m'

    def connect(self):
        # Initialiser le navigateur
        driver = webdriver.Chrome() 
        driver.get("http://localhost/ypopsi") 
        
        # Attente du chargement
        time.sleep(0.5)
        
        action_button = driver.find_element(By.ID, "action-button") 
        action_button.click()
        
        # Attente de l'animation
        time.sleep(0.7)
        
        # Saisir l'identifiant
        username_input = driver.find_element(By.ID, "identifiant") 
        username_input.send_keys("test.py")
        
        # Saisir le mot de passe
        password_input = driver.find_element(By.ID, "motdepasse") 
        password_input.send_keys("test123")
        password_input.send_keys(Keys.RETURN)

        return driver 
    
    def goToApplications(self, driver): 
        # Attendre que le lien "Applications" soit cliquable et cliquer dessus
        applications_link = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "//a[contains(@href, 'applications=home')]"))
        )
        applications_link.click()

    def clickOnFirstAplications(self, driver): 
        # Attendre que la liste des candidatures soit visible
        WebDriverWait(driver, 10).until(
            EC.visibility_of_element_located((By.CLASS_NAME, "table-wrapper"))  # Assurez-vous que la classe est correcte
        )
        
        # Trouver la première ligne de la table des candidatures
        first_application_row = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, ".table-wrapper tbody tr:first-child"))
        )
        
        # Cliquer sur la première candidature
        first_application_row.click()        

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
    
    # Tests
    # runner.run_test("Tests dse connexions ", "tests/selenium/connexion/connect.py")
    runner.run_test("Tests des candidats", "tests/selenium/candidate/candidate.py")
    
    print(f"\n{TestRunner.BLEU}=== Fin des tests Selenium ==={TestRunner.RESET}")

if __name__ == "__main__":
    main()