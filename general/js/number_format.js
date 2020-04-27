    function number_format(numero,decimals=0){
        var numbero_formatear=parseFloat(numero);
        return (numbero_formatear.toLocaleString('en-IN', {minimumFractionDigits: decimals, maximumFractionDigits: decimals}))
    }