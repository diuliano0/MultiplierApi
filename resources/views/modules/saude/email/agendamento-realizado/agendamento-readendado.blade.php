<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Demystifying Email Design</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="padding: 10px 0 30px 0;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                <tr>
                    <td align="center" bgcolor="#00719d" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                        <img src="http://medbrasil.com.br:90/assets/logo-mini-medbrasil.png" alt="Creating Email Magic" width="130" height="130" style="display: block;" />
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                    <b>MedBrasil - Reagendamento de Consultas</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                    Ola,<br /><br />
                                    Foi realizado pela clínica ou aplicativo o reagendamento do agendamento realizado pelo aplicativo MedBrasil.
                                    Segue os dados da consulta para seu conhecimento:<br />
                                    <br /><br />
                                    Nome Paciente: {{ $agendamento["beneficiario_nome"]}}<br />
                                    Cpf Paciente: {{ $agendamento["cpf_cnpj"] }}<br />
                                    Data de Cadastro: {{ $agendamento["dt_cadastro"]}}<br />
                                    Fone Paciente: {{$agendamento["telefone"]}}<br />
                                    Profissional: {{ $agendamento["prestador_servico_nome"] }}<br />
                                    Especialidade: {{$agendamento['especialidade']}}<br />
                                    @if($agendamento["convenio"]) Convênio: {{$agendamento["convenio"]}} <br />@endif
                                    Data Hora: {{ $agendamento["dh_inicio"]}}<br />
                                    Local Atendimento: {{ $agendamento["local"]}}<br />
                                    Endereco: {{$agendamento["endereco"]}}<br />
                                    @if(!$agendamento["convenio"])Valor da consulta: R$ {{$agendamento["valor"]}}<br />@endif
                                    <br /><br />

                                    Este comunicado de serviço é obrigatório e foi enviado para informar você sobre alterações importantes realizadas no aplicativo MedBrasil ou na sua conta.<br />

                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#e50e16" style="padding: 30px 30px 30px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                                    &reg; Todos os Direitos reservados 2019<br/>

                                </td>
                                <td align="right" width="25%">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                <a href="http://www.twitter.com/" style="color: #ffffff;">
                                                    <img src="http://medbrasil.com.br:90/assets/play.png" alt="Twitter" width="42" height="38" style="display: block;" border="0" />
                                                </a>
                                            </td>
                                            <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                            <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                <a href="http://www.twitter.com/" style="color: #ffffff;">
                                                    <img src="http://medbrasil.com.br:90/assets/apple.png" alt="Facebook" width="34" height="38" style="display: block;" border="0" />
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
