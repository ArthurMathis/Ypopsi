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

class ConnectSuccessTest(TestRunner):
    def test_login_form(self):
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
                # Remplissage du formulaire
                identifiant = driver.find_element(By.ID, "identifiant")
                identifiant.send_keys("mathis.a")
                
                motdepasse = driver.find_element(By.ID, "motdepasse")
                motdepasse.send_keys("Arthur123")
                
                # Soumission du formulaire
                submit_button = driver.find_element(By.CSS_SELECTOR, "button[type='submit']")
                submit_button.click()
            except Exception as e:
                print(f"{self.ROUGE}Erreur lors de la manipulation du formulaire : {str(e)}{self.RESET}")
                return False

            # Attente pour voir le résultat
            time.sleep(0.5)
            
            print(f"{self.VERT}Test réussi !{self.BLANC} Le formulaire a été rempli et soumis avec succès{self.RESET}")
            return True

        except Exception as e:
            print(f"{self.ROUGE}Erreur inattendue : {str(e)}{self.RESET}")
            return False
            
        finally:
            driver.quit()

if __name__ == "__main__":
    test = ConnectSuccessTest()
    test.test_login_form()