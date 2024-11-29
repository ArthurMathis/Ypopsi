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

class DisconnectTest(TestRunner):
    def test_disconnect(self):
        driver = webdriver.Chrome()
        
        try:
            # Première étape : connexion
            try:
                driver.get("http://localhost/ypopsi")
                
                # Clic sur le bouton d'action
                action_button = WebDriverWait(driver, 10).until(
                    EC.element_to_be_clickable((By.ID, "action-button"))
                )
                action_button.click()
                
                # Attente de l'animation
                time.sleep(0.7)
                
                # Remplissage du formulaire
                identifiant = driver.find_element(By.ID, "identifiant")
                identifiant.send_keys("mathis.a")
                
                motdepasse = driver.find_element(By.ID, "motdepasse")
                motdepasse.send_keys("Arthur123")
                
                # Soumission du formulaire
                submit_button = driver.find_element(By.CSS_SELECTOR, "button[type='submit']")
                submit_button.click()
                
                # Attente que la page d'accueil soit chargée
                time.sleep(1)
                
            except Exception as e:
                print(f"{self.ROUGE}Erreur lors de la connexion : {str(e)}{self.RESET}")
                return False

            # Deuxième étape : déconnexion
            try:
                # Clic sur le lien de déconnexion
                disconnect_link = driver.find_element(By.CSS_SELECTOR, "a[href='index.php?login=deconnexion']")
                disconnect_link.click()
                
                # Vérification que nous sommes retournés à la page de connexion
                time.sleep(0.5)
                current_url = driver.current_url
                if "login=get_connexion" in current_url or "login=connexion" in current_url:
                    print(f"{self.VERT}Test réussi !{self.BLANC} L'utilisateur a été déconnecté avec succès{self.RESET}")
                    return True
                else:
                    print(f"{self.ROUGE}Échec du test :{self.BLANC} La déconnexion n'a pas redirigé vers la page de connexion{self.RESET}")
                    return False
                    
            except Exception as e:
                print(f"{self.ROUGE}Erreur lors de la déconnexion : {str(e)}{self.RESET}")
                return False

        except Exception as e:
            print(f"{self.ROUGE}Erreur inattendue : {str(e)}{self.RESET}")
            return False
            
        finally:
            driver.quit()

if __name__ == "__main__":
    test = DisconnectTest()
    test.test_disconnect()