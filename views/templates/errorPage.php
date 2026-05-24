<?php
// Template pour afficher une page d'erreur 
?>
<section class="error-section flex justify-center items-center">
    <div class="container flex flex-col justify-center items-center">
        <div class="error-container-side">
            <p>Oups...</p>
        </div>
        <div class="error-container flex flex-col items-center">
            <h1>Une erreur s'est produite :</h1>
            <div class="error-message-container flex flex-col items-center">
                <?= $errorMessage ?>
            </div>
        </div>
    </div>
</section>