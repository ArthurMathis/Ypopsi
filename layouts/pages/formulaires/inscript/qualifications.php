<form class="small-form" method="post" action="index.php?preferences=inscript-qualifications">
    <h3>Saisissez les informations du nouveau poste</h3>
    <section>
        <div class="input-container">
            <p>Intitulé</p>
            <input type="text" id="titled" name="titled" placeholder="Aide soignant D.E.">
        </div>
        <div class="input-container">
            <p>Abréviation</p>
            <input type="text" id="abreviation" name="abreviation" placeholder="A.S.">
        </div>
        <div class="checkbox-liste">
            <div class="checkbox-item">
                <label for="medical_staff">Diplôme méical</label>
                <input type="checkbox" id="medical_staff" name="medical_staff">
            </div>
        </div>
    </section>
    <button type="submit" class="submit_button" value="new_user">Valider</button>
</form>