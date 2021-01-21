<?php
$op = "";

while($op != 's'){
    print "Digite a seguinte opção \n\n";
    print "'m' para criar o model\n";
    print "'r' para criar o request\n";
    print "'c' para criar a Criteria\n";
    print "'ct' para criar o Controller\n";
    print "'rp' para criar o Repository\n";
    print "'rot' para criar a Rota\n";
    print "'t' para criar a Transformer\n";
    print "'o' para criar os demais arquivos\n";
    print "'p' para criar apenas o escopo de (repository, transformer e service)\n";
    print "'e' para remover todos os arquivos\n";
    print "'s' para sair\n";
    $op = readline();
    clear();
    if($op == 's'){
        print "script finalizado";
        break;
    }
    echo "Digite o nome do módulo\n";
    $modulo = readline();
    switch ($op){
        case 'e':
            print "digite o nome das classes\n";
            $classname = readline();
            if(file_exists(__DIR__."/Modules/$modulo/Criteria/".$classname."Criteria.php")){
                unlink(__DIR__."/Modules/$modulo/Criteria/".$classname."Criteria.php");
            }
            if(file_exists(__DIR__."/Modules/$modulo/Http/Controllers/Api/Admin/".$classname."Controller.php")){
                unlink(__DIR__."/Modules/$modulo/Http/Controllers/Api/Admin/".$classname."Controller.php");
            }
            if(file_exists(__DIR__."/Modules/$modulo/Http/Requests/".$classname."Request.php")){
                unlink(__DIR__."/Modules/$modulo/Http/Requests/".$classname."Request.php");
            }
            if(file_exists(__DIR__."/Modules/$modulo/Models/".$classname.".php")){
                unlink(__DIR__."/Modules/$modulo/Models/".$classname.".php");
            }
            if(file_exists(__DIR__."/Modules/$modulo/Presenters/".$classname."Presenter.php")){
                unlink(__DIR__."/Modules/$modulo/Presenters/".$classname."Presenter.php");
            }
            if(file_exists(__DIR__."/Modules/$modulo/Repositories/".$classname."RepositoryEloquent.php")){
                unlink(__DIR__."/Modules/$modulo/Repositories/".$classname."RepositoryEloquent.php");
            }
            if(file_exists(__DIR__."/Modules/$modulo/Repositories/".$classname."Repository.php")){
                unlink(__DIR__."/Modules/$modulo/Repositories/".$classname."Repository.php");
            }
            if(file_exists(__DIR__."/Modules/$modulo/Rotas/".$classname."Route.php")){
                unlink(__DIR__."/Modules/$modulo/Rotas/".$classname."Route.php");
            }
            if(file_exists(__DIR__."/Modules/$modulo/Services/".$classname."Service.php")){
                unlink(__DIR__."/Modules/$modulo/Services/".$classname."Service.php");
            }
            if(file_exists(__DIR__."/Modules/$modulo/Transformers/".$classname."Transformer.php")){
                unlink(__DIR__."/Modules/$modulo/Transformers/".$classname."Transformer.php");
            }
            break;
        case 'm':

            /*
             * criando o model
             * */
            print "digite o nome do model\n";
            $model = readline();
            quebraDeLinha();

            print "digite o nome da tabela (opcional)\n";
            $tabela = readline();
            quebraDeLinha();

            print "digite o nome da conexão (opcional)\n";
            $conexao = readline();
            quebraDeLinha();

            print "digite o nome dos campos fillable (opcional)\n";
            $campos = readline();
            quebraDeLinha();

            if(notEmpty($tabela)){
                $tabela = " --tabela \"$tabela\"";
            }
            if(notEmpty($conexao)){
                $conexao = " --conexao \"$conexao\"";
            }
            if(notEmpty($campos)){
                $campos = " --campos $campos";
            }
            passthru(phppath().' artisan generate DModel '.$model.' --modulo "'.$modulo.'"'.$tabela.$conexao.$campos);
            quebraDeLinha();
            print "model gerado com sucesso!;";
            quebraDeLinha();
            break;
        case 'r':
            /*
             * criando os request
             * */
            print "digite o nome do request\n";
            $classname = readline();
            execGenerator('DRequest', $classname, $modulo);
            break;
        case 'c':
            /*
             * criando os request
             * */
            print "digite o nome da Criteria\n";
            $classname = readline();
            execGenerator('DCriteria', $classname, $modulo);
            break;
        case 'ct':
            /*
             * criando os request
             * */
            print "digite o nome do controller\n";
            $classname = readline();
            execGenerator('DController', $classname, $modulo);
            break;
        case 'rp':
            /*
             * criando os request
             * */
            print "digite o nome do Repository\n";
            $classname = readline();
            execGenerator('DIRepository', $classname, $modulo);
            execGenerator('DRepository', $classname, $modulo);
            break;
        case 'rot':
            /*
             * criando os request
             * */
            print "digite o nome da Rota\n";
            $classname = readline();
            execGenerator('DRota', $classname, $modulo);
            break;
        case 't':
            /*
             * criando os request
             * */
            print "digite o nome do Transformer/Presenter\n";
            $classname = readline();
            execGenerator('DTransformer', $classname, $modulo);
            execGenerator('DPresenter', $classname, $modulo);
            break;
        case 's':
            /*
             * criando os request
             * */
            print "digite o nome do Service\n";
            $classname = readline();
            execGenerator('DService', $classname, $modulo);
            break;
        case 'o':
            /*
             * criando todos
             * */
            print "digite o nome das classes\n";
            $classname = readline();
            execGenerator('DRequest', $classname, $modulo);
            execGenerator('DCriteria', $classname, $modulo);
            execGenerator('DController', $classname, $modulo);
            execGenerator('DIRepository', $classname, $modulo);
            execGenerator('DRepository', $classname, $modulo);
            execGenerator('DRota', $classname, $modulo);
            execGenerator('DTransformer', $classname, $modulo);
            execGenerator('DPresenter', $classname, $modulo);
            execGenerator('DService', $classname, $modulo);
            break;
        case 'p':
            /*
             * criando todos
             * */
            print "digite o nome das classes\n";
            $classname = readline();
            execGenerator('DIRepository', $classname, $modulo);
            execGenerator('DRepository', $classname, $modulo);
            execGenerator('DTransformer', $classname, $modulo);
            execGenerator('DPresenter', $classname, $modulo);
            execGenerator('DService', $classname, $modulo);
            break;
    }
}

function clear(){
    passthru('clear');
}

function quebraDeLinha(){
    print "\n\n";
}

function phppath(){
    return 'php';
}

function notEmpty($val){
    return !is_null($val) && !empty($val);
}

function execGenerator($function, $classname, $modulo){
    passthru(phppath().' artisan generate '.$function.' '.$classname.' --modulo "'.$modulo.'"');
}
