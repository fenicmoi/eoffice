<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include "inc/connect_db.php";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Untitled Document</title>
<link href="../mystyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-top: 20px;
}
-->
</style></head>

<body>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="title_bg_text">��������ǹ��Ǽ������к�</td>
  </tr>
</table>
<form action="add_form.php" name="form1" method="post">
<table width="56%" border="0" align="center" cellpadding="3" cellspacing="5">
  
  <tr>
    <td width="26%"><div align="right">˹��§ҹ/������ҹ : </div></td>
    <td width="74%"><input name="dept" type="text" id="dept" size="40" /></td>
  </tr>
  <tr>
    <td><div align="right">��Ъ������ͧ : </div></td>
    <td><input name="subject" type="text" id="subject" size="40" /></td>
  </tr>
  <tr>
    <td><div align="right">��иҹ㹷���Ъ�� : </div></td>
    <td><input name="header" type="text" id="header" size="40" /></td>
  </tr>
  <tr>
    <td><div align="right">�ӹǹ�����һ�Ъ�� : </div></td>
    <td><input name="nummeeting" type="text" id="nummeeting" size="40" /></td>
  </tr>
  <tr>
    <td><div align="right">��ͧ������Ъ�� : </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="right">�ѹ������������ͧ : </div></td>
    <td><select name="startdate" id="startdate">
      <option value="0" selected="selected">�ѹ���</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
      <option value="14">13</option>
      <option value="15">15</option>
      <option value="16">16</option>
      <option value="17">17</option>
      <option value="18">18</option>
      <option value="19">19</option>
      <option value="20">20</option>
      <option value="21">21</option>
      <option value="22">22</option>
      <option value="23">23</option>
      <option value="24">24</option>
      <option value="25">25</option>
      <option value="26">26</option>
      <option value="27">27</option>
      <option value="28">28</option>
      <option value="29">29</option>
      <option value="30">30</option>
      <option value="31">31</option>
    </select>
      <select name="startmonth" id="startmonth">
        <option value="0" selected="selected">��͹</option>
        <option value="1">���Ҥ�</option>
        <option value="2">����Ҿѹ��</option>
        <option value="3">�չҤ�</option>
        <option value="4">����¹</option>
        <option value="5">����Ҥ�</option>
        <option value="6">�Զع�¹</option>
        <option value="7">�á�Ҥ�</option>
        <option value="8">�ԧ�Ҥ�</option>
        <option value="9">�ѹ��¹</option>
        <option value="10">���Ҥ�</option>
        <option value="11">��Ȩԡ�¹</option>
        <option value="12">�ѹ�Ҥ�</option>
      </select>
       <select name="startyear" id="startyear">
         <option value="0" selected="selected">��</option>
         <option value="2550">2550</option>
         <option value="2551">2551</option>
         <option value="2552">2552</option>
         <option value="2553">2553</option>
         <option value="2554">2554</option>
         <option value="2555">2555</option>
       </select>      </td>
  </tr>
  <tr>
    <td><div align="right">�ѹ����ش����ͧ : </div></td>
    <td><select name="enddate" id="enddate">
      <option value="0" selected="selected">�ѹ���</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
      <option value="14">13</option>
      <option value="15">15</option>
      <option value="16">16</option>
      <option value="17">17</option>
      <option value="18">18</option>
      <option value="19">19</option>
      <option value="20">20</option>
      <option value="21">21</option>
      <option value="22">22</option>
      <option value="23">23</option>
      <option value="24">24</option>
      <option value="25">25</option>
      <option value="26">26</option>
      <option value="27">27</option>
      <option value="28">28</option>
      <option value="29">29</option>
      <option value="30">30</option>
      <option value="31">31</option>
    </select>
      <select name="endmonth" id="endmonth">
        <option value="0" selected="selected">��͹</option>
        <option value="1">���Ҥ�</option>
        <option value="2">����Ҿѹ��</option>
        <option value="3">�չҤ�</option>
        <option value="4">����¹</option>
        <option value="5">����Ҥ�</option>
        <option value="6">�Զع�¹</option>
        <option value="7">�á�Ҥ�</option>
        <option value="8">�ԧ�Ҥ�</option>
        <option value="9">�ѹ��¹</option>
        <option value="10">���Ҥ�</option>
        <option value="11">��Ȩԡ�¹</option>
        <option value="12">�ѹ�Ҥ�</option>
      </select>
      <select name="endyear" id="endyear">
        <option value="0" selected="selected">��</option>
        <option value="2550">2550</option>
        <option value="2551">2551</option>
        <option value="2552">2552</option>
        <option value="2553">2553</option>
        <option value="2554">2554</option>
        <option value="2555">2555</option>
      </select></td>
  </tr>
  <tr>
    <td><div align="right">��ǧ���ҷ���� : </div></td>
    <td><select name="starttime" id="starttime">
      <option value="0" selected="selected">����</option>
      <option value="08:00:00">08:00</option>
      <option value="09:00:00">09:00</option>
      <option value="10:00:00">10:00</option>
      <option value="11:00:00">11:00</option>
      <option value="12:00:00">12:00</option>
      <option value="13:00:00">13:00</option>
      <option value="14:00:00">14:00</option>
      <option value="15:00:00">15:00</option>
      <option value="16:00:00">16:00</option>
    </select>
      �֧ 
      <select name="endtime" id="endtime">
        <option value="0" selected="selected">����</option>
        <option value="08:00:00">08:00</option>
        <option value="09:00:00">09:00</option>
        <option value="10:00:00">10:00</option>
        <option value="11:00:00">11:00</option>
        <option value="12:00:00">12:00</option>
        <option value="13:00:00">13:00</option>
        <option value="14:00:00">14:00</option>
        <option value="15:00:00">15:00</option>
        <option value="16:00:00">16:00</option>
      </select></td>
  </tr>
  <tr>
    <td><div align="right">�ػ�ó����� : </div></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><div align="right">���������� : </div></td>
    <td><table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="44%"><input name="food1" type="checkbox" id="food1" value="checkbox" />
          �������ҧ���</td>
        <td width="56%"><input name="food3" type="checkbox" id="food3" value="checkbox" />
          ����á�ҧ�ѹ</td>
      </tr>
      <tr>
        <td><input name="food2" type="checkbox" id="food2" value="checkbox" />
          �������ҧ����</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><div align="right">ŧ���ͼ��ͧ : </div></td>
    <td><input name="namefill" type="text" id="namefill" size="40" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="button" name="Button" value="�ͧ��ͧ��Ъ��" onclick="chkform();"/> <input type="reset" name="Submit2" value="¡��ԡ" /></td>
  </tr>
</table>
</form>
</body>
</html>
