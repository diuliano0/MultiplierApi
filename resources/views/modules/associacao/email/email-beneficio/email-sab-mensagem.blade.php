<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>ProTocantins</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="padding: 10px 0 30px 0;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #fff; border-collapse: collapse;">
                <tr>
                    <td align="center" bgcolor="#1185C7" style="padding: 30px 0 30px 0; color: #fff; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                        <img src="http://lookeiapi.macrolabs.com.br/logo_princ.png" width="150" height="80" style="display: block;" />
                    </td>
                </tr>
                <tr class="content-page">
                    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                    <b>Mensagem SAB</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 20px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                    <br/>
                                        <b>Nome:</b> {{ $data["trabalhador"]["nome_trabalhador"] }}<br />
                                        <b>E-mail:</b> {{ $data["trabalhador"]["email_trabalhador"] }}<br />
                                        <b>CPF:</b> {{ $data["trabalhador"]["cpf_cnpj"] }}<br />
                                    <br/>
                                    <b>Mensagem:</b> <br />{{ $data["msg"]}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#1185C7" style="padding: 20px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                                    ProTocantins &reg; Todos os Direitos reservados<br/>

                                </td>
                                <td align="right" width="25%">
                                    <table border="0" cellpadding="0" cellspacing="0">
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
