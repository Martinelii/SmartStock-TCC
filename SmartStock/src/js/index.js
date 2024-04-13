// função global de navegabilidade (nao gostei de como ficou, isso vai precisar de ajustes depois) -LL
function irPara(pagina){
    if (isLocalHost()){
        try{
            window.location.href = "./" + pagina + "/";
        } catch {}
        try{
            window.location.href = "../" + pagina + "/";
        } catch {}
    }
    else{
        try{
            window.open("https://https://martinelii.github.io/SmartStock/" + pagina + "/", "_self");
        } catch {}
        try{
            window.open("https://https://martinelii.github.io/SmartStock/" + pagina + "/", "_self");
        } catch {}
    }
}

function isLocalHost() {
    if (location.hostname === "localhost" || location.hostname === "127.0.0.1" || location.hostname === "")
        return true;
    return false;
}

//acho que seria muito daora se tivesse como fazer uma barra de carregamento que fosse concondizente com a realidade -LL

//acredito que a ditribuição das paginas pode ser melhorada, mas pra isso teriamos que reestruturar uma porrada de coisa, mas isso é óbvio -LL