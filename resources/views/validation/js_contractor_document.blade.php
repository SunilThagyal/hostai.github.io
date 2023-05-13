<script>
    jQuery(document).ready(function() {
        const rules = {
        }
        const messages = {
        };

        handleValidation('filesVerification', rules, messages);
        $('.filesVerification').each(function(){
            handleValidation($(this), rules, messages);
        });

    });
</script>
