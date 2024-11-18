import sys
import os
sys.path.append(os.path.dirname(os.path.dirname(os.path.dirname(os.path.dirname(__file__)))))

from tests.selenium.run_test import TestRunner
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException, WebDriverException
import time

class ConnectFailureTest(TestRunner):
    def test_login_form_error(self):
        driver = webdriver.Chrome()
        
        try:
            # Accès à la page
            try:
                driver.get("http://localhost/ypopsi")
            except WebDriverException as e:
                print(f"{self.ROUGE}Erreur lors de l'accès à la page : {str(e)}{self.RESET}")
                return False

            # Attente et clic sur le bouton d'action
            try:
                action_button = WebDriverWait(driver, 10).until(
                    EC.element_to_be_clickable((By.ID, "action-button"))
                )
                action_button.click()
            except TimeoutException:
                print(f"{self.ROUGE}Erreur : Le bouton d'action n'a pas été trouvé ou n'est pas cliquable{self.RESET}")
                return False

            # Attente de l'animation
            time.sleep(0.7)

            try:
                # Remplissage du formulaire avec des données incorrectes
                identifiant = driver.find_element(By.ID, "identifiant")
                identifiant.send_keys("utilisateur_inexistant")
                
                motdepasse = driver.find_element(By.ID, "motdepasse")
                motdepasse.send_keys("mauvais_mot_de_passe")
                
                # Soumission du formulaire
                submit_button = driver.find_element(By.CSS_SELECTOR, "button[type='submit']")
                submit_button.click()
            except Exception as e:
                print(f"{self.ROUGE}Erreur lors de la manipulation du formulaire : {str(e)}{self.RESET}")
                return False

            # Attente pour voir le résultat
            time.sleep(0.5)
            
            # Vérification que nous sommes toujours sur la page de connexion
            current_url = driver.current_url
            if "login" in current_url or "connexion" in current_url:
                print(f"{self.VERT}Test réussi !{self.BLANC} L'accès a été correctement refusé{self.RESET}")
                return True
            else:
                print(f"{self.ROUGE}Échec du test :{self.BLANC} L'accès n'a pas été refusé comme prévu{self.RESET}")
                return False

        except Exception as e:
            print(f"{self.ROUGE}Erreur inattendue : {str(e)}{self.RESET}")
            return False
            
        finally:
            driver.quit()

if __name__ == "__main__":
    test = ConnectFailureTest()
    test.test_login_form_error()