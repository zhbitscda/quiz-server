<!DOCTYPE html><html>

<head>
<meta charset="utf-8">
<title>errorCodeDoc</title>
<style type="text/css">
body {
  font-family: Helvetica, arial, sans-serif;
  font-size: 14px;
  line-height: 1.6;
  padding-top: 10px;
  padding-bottom: 10px;
  background-color: white;
  padding: 30px; }

body > *:first-child {
  margin-top: 0 !important; }
body > *:last-child {
  margin-bottom: 0 !important; }

a {
  color: #4183C4; }
a.absent {
  color: #cc0000; }
a.anchor {
  display: block;
  padding-left: 30px;
  margin-left: -30px;
  cursor: pointer;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0; }

h1, h2, h3, h4, h5, h6 {
  margin: 20px 0 10px;
  padding: 0;
  font-weight: bold;
  -webkit-font-smoothing: antialiased;
  cursor: text;
  position: relative; }

h1:hover a.anchor, h2:hover a.anchor, h3:hover a.anchor, h4:hover a.anchor, h5:hover a.anchor, h6:hover a.anchor {
  background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA09pVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoMTMuMCAyMDEyMDMwNS5tLjQxNSAyMDEyLzAzLzA1OjIxOjAwOjAwKSAgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6OUM2NjlDQjI4ODBGMTFFMTg1ODlEODNERDJBRjUwQTQiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6OUM2NjlDQjM4ODBGMTFFMTg1ODlEODNERDJBRjUwQTQiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo5QzY2OUNCMDg4MEYxMUUxODU4OUQ4M0REMkFGNTBBNCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo5QzY2OUNCMTg4MEYxMUUxODU4OUQ4M0REMkFGNTBBNCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PsQhXeAAAABfSURBVHjaYvz//z8DJYCRUgMYQAbAMBQIAvEqkBQWXI6sHqwHiwG70TTBxGaiWwjCTGgOUgJiF1J8wMRAIUA34B4Q76HUBelAfJYSA0CuMIEaRP8wGIkGMA54bgQIMACAmkXJi0hKJQAAAABJRU5ErkJggg==) no-repeat 10px center;
  text-decoration: none; }

h1 tt, h1 code {
  font-size: inherit; }

h2 tt, h2 code {
  font-size: inherit; }

h3 tt, h3 code {
  font-size: inherit; }

h4 tt, h4 code {
  font-size: inherit; }

h5 tt, h5 code {
  font-size: inherit; }

h6 tt, h6 code {
  font-size: inherit; }

h1 {
  font-size: 28px;
  color: black; }

h2 {
  font-size: 24px;
  border-bottom: 1px solid #cccccc;
  color: black; }

h3 {
  font-size: 18px; }

h4 {
  font-size: 16px; }

h5 {
  font-size: 14px; }

h6 {
  color: #777777;
  font-size: 14px; }

p, blockquote, ul, ol, dl, li, table, pre {
  margin: 15px 0; }

hr {
  background: transparent url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAYAAAAECAYAAACtBE5DAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBNYWNpbnRvc2giIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6OENDRjNBN0E2NTZBMTFFMEI3QjRBODM4NzJDMjlGNDgiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6OENDRjNBN0I2NTZBMTFFMEI3QjRBODM4NzJDMjlGNDgiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo4Q0NGM0E3ODY1NkExMUUwQjdCNEE4Mzg3MkMyOUY0OCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo4Q0NGM0E3OTY1NkExMUUwQjdCNEE4Mzg3MkMyOUY0OCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PqqezsUAAAAfSURBVHjaYmRABcYwBiM2QSA4y4hNEKYDQxAEAAIMAHNGAzhkPOlYAAAAAElFTkSuQmCC) repeat-x 0 0;
  border: 0 none;
  color: #cccccc;
  height: 4px;
  padding: 0;
}

body > h2:first-child {
  margin-top: 0;
  padding-top: 0; }
body > h1:first-child {
  margin-top: 0;
  padding-top: 0; }
  body > h1:first-child + h2 {
    margin-top: 0;
    padding-top: 0; }
body > h3:first-child, body > h4:first-child, body > h5:first-child, body > h6:first-child {
  margin-top: 0;
  padding-top: 0; }

a:first-child h1, a:first-child h2, a:first-child h3, a:first-child h4, a:first-child h5, a:first-child h6 {
  margin-top: 0;
  padding-top: 0; }

h1 p, h2 p, h3 p, h4 p, h5 p, h6 p {
  margin-top: 0; }

li p.first {
  display: inline-block; }
li {
  margin: 0; }
ul, ol {
  padding-left: 30px; }

ul :first-child, ol :first-child {
  margin-top: 0; }

dl {
  padding: 0; }
  dl dt {
    font-size: 14px;
    font-weight: bold;
    font-style: italic;
    padding: 0;
    margin: 15px 0 5px; }
    dl dt:first-child {
      padding: 0; }
    dl dt > :first-child {
      margin-top: 0; }
    dl dt > :last-child {
      margin-bottom: 0; }
  dl dd {
    margin: 0 0 15px;
    padding: 0 15px; }
    dl dd > :first-child {
      margin-top: 0; }
    dl dd > :last-child {
      margin-bottom: 0; }

blockquote {
  border-left: 4px solid #dddddd;
  padding: 0 15px;
  color: #777777; }
  blockquote > :first-child {
    margin-top: 0; }
  blockquote > :last-child {
    margin-bottom: 0; }

table {
  padding: 0;border-collapse: collapse; }
  table tr {
    border-top: 1px solid #cccccc;
    background-color: white;
    margin: 0;
    padding: 0; }
    table tr:nth-child(2n) {
      background-color: #f8f8f8; }
    table tr th {
      font-weight: bold;
      border: 1px solid #cccccc;
      margin: 0;
      padding: 6px 13px; }
    table tr td {
      border: 1px solid #cccccc;
      margin: 0;
      padding: 6px 13px; }
    table tr th :first-child, table tr td :first-child {
      margin-top: 0; }
    table tr th :last-child, table tr td :last-child {
      margin-bottom: 0; }

img {
  max-width: 100%; }

span.frame {
  display: block;
  overflow: hidden; }
  span.frame > span {
    border: 1px solid #dddddd;
    display: block;
    float: left;
    overflow: hidden;
    margin: 13px 0 0;
    padding: 7px;
    width: auto; }
  span.frame span img {
    display: block;
    float: left; }
  span.frame span span {
    clear: both;
    color: #333333;
    display: block;
    padding: 5px 0 0; }
span.align-center {
  display: block;
  overflow: hidden;
  clear: both; }
  span.align-center > span {
    display: block;
    overflow: hidden;
    margin: 13px auto 0;
    text-align: center; }
  span.align-center span img {
    margin: 0 auto;
    text-align: center; }
span.align-right {
  display: block;
  overflow: hidden;
  clear: both; }
  span.align-right > span {
    display: block;
    overflow: hidden;
    margin: 13px 0 0;
    text-align: right; }
  span.align-right span img {
    margin: 0;
    text-align: right; }
span.float-left {
  display: block;
  margin-right: 13px;
  overflow: hidden;
  float: left; }
  span.float-left span {
    margin: 13px 0 0; }
span.float-right {
  display: block;
  margin-left: 13px;
  overflow: hidden;
  float: right; }
  span.float-right > span {
    display: block;
    overflow: hidden;
    margin: 13px auto 0;
    text-align: right; }

code, tt {
  margin: 0 2px;
  padding: 0 5px;
  white-space: nowrap;
  border: 1px solid #eaeaea;
  background-color: #f8f8f8;
  border-radius: 3px; }

pre code {
  margin: 0;
  padding: 0;
  white-space: pre;
  border: none;
  background: transparent; }

.highlight pre {
  background-color: #f8f8f8;
  border: 1px solid #cccccc;
  font-size: 13px;
  line-height: 19px;
  overflow: auto;
  padding: 6px 10px;
  border-radius: 3px; }

pre {
  background-color: #f8f8f8;
  border: 1px solid #cccccc;
  font-size: 13px;
  line-height: 19px;
  overflow: auto;
  padding: 6px 10px;
  border-radius: 3px; }
  pre code, pre tt {
    background-color: transparent;
    border: none; }

sup {
    font-size: 0.83em;
    vertical-align: super;
    line-height: 0;
}
* {
	-webkit-print-color-adjust: exact;
}
@media screen and (min-width: 914px) {
    body {
        width: 854px;
        margin:0 auto;
    }
}
@media print {
	table, pre {
		page-break-inside: avoid;
	}
	pre {
		word-wrap: break-word;
	}
}
</style>
</head>
<body>
<h2 id="toc_0">错误码说明文档</h2>

<table>
<thead>
<tr>
<th>错误码</th>
<th>说明</th>
</tr>
</thead>

<tbody>
<tr>
<td>-1001</td>
<td>参数错误</td>
</tr>
<tr>
<td>-1002</td>
<td>数据库执行失败</td>
</tr>
<tr>
<td>-1003</td>
<td>accessToken 为空</td>
</tr>
<tr>
<td>-1004</td>
<td>服务器验证 accessToken 失败</td>
</tr>
<tr>
<td>-1005</td>
<td>配置不一致错误</td>
</tr>
<tr>
<td>-1006</td>
<td>服务器维护中</td>
</tr>
<tr>
<td>-1101</td>
<td>operatorId 为空</td>
</tr>
<tr>
<td>-1102</td>
<td>operatorId 不存在</td>
</tr>
<tr>
<td>-1111</td>
<td>用户名为空</td>
</tr>
<tr>
<td>-1112</td>
<td>用户名已经存在</td>
</tr>
<tr>
<td>-1113</td>
<td>密码为空</td>
</tr>
<tr>
<td>-1114</td>
<td>账号或密码错误</td>
</tr>
<tr>
<td>-1201</td>
<td>roleId 为空</td>
</tr>
<tr>
<td>-1202</td>
<td>roleId 不存在</td>
</tr>
<tr>
<td>-1203</td>
<td>roleId 已被使用</td>
</tr>
<tr>
<td>-1211</td>
<td>roleName 为空</td>
</tr>
<tr>
<td>-1212</td>
<td>roleName 已存在</td>
</tr>
<tr>
<td>-1301</td>
<td>permissionId 为空</td>
</tr>
<tr>
<td>-1302</td>
<td>permissionId 已被使用</td>
</tr>
<tr>
<td>-1311</td>
<td>permissions 为空</td>
</tr>
<tr>
<td>-1312</td>
<td>permissions 有误</td>
</tr>
<tr>
<td>-1401</td>
<td>cardId 为空</td>
</tr>
<tr>
<td>-1402</td>
<td>cardId 不存在</td>
</tr>
<tr>
<td>-1403</td>
<td>cardId 已经被使用</td>
</tr>
<tr>
<td>-1411</td>
<td>property 为空</td>
</tr>
<tr>
<td>-1412</td>
<td>property 格式有误</td>
</tr>
<tr>
<td>-1413</td>
<td>deposit 为空</td>
</tr>
<tr>
<td>-1414</td>
<td>deposit 格式有误</td>
</tr>
<tr>
<td>-1415</td>
<td>printNo 为空</td>
</tr>
<tr>
<td>-1416</td>
<td>status 为空</td>
</tr>
<tr>
<td>-1417</td>
<td>status 格式有误</td>
</tr>
<tr>
<td>-1420</td>
<td>未开通车停卡功能</td>
</tr>
<tr>
<td>-1421</td>
<td>cardTypeId 为空</td>
</tr>
<tr>
<td>-1422</td>
<td>cardTypeId 不存在</td>
</tr>
<tr>
<td>-1431</td>
<td>times 为空</td>
</tr>
<tr>
<td>-1432</td>
<td>times 格式有误</td>
</tr>
<tr>
<td>-1433</td>
<td>balance 为空</td>
</tr>
<tr>
<td>-1434</td>
<td>balance 格式有误</td>
</tr>
<tr>
<td>-1435</td>
<td>boxRight 为空</td>
</tr>
<tr>
<td>-1436</td>
<td>isNote 为空</td>
</tr>
<tr>
<td>-1437</td>
<td>isNote 格式有误</td>
</tr>
<tr>
<td>-1438</td>
<td>remark 为空</td>
</tr>
<tr>
<td>-1439</td>
<td>beginDate 为空</td>
</tr>
<tr>
<td>-1440</td>
<td>endDate 为空</td>
</tr>
<tr>
<td>-1501</td>
<td>carId 为空</td>
</tr>
<tr>
<td>-1502</td>
<td>carId 不存在</td>
</tr>
<tr>
<td>-1511</td>
<td>carTypeId 为空</td>
</tr>
<tr>
<td>-1512</td>
<td>carTypeId 不存在</td>
</tr>
<tr>
<td>-1521</td>
<td>carLocId 为空</td>
</tr>
<tr>
<td>-1522</td>
<td>carLocId 不存在</td>
</tr>
<tr>
<td>-1531</td>
<td>carPhotoId 为空</td>
</tr>
<tr>
<td>-1532</td>
<td>carPhotoId 不存在</td>
</tr>
<tr>
<td>-1541</td>
<td>carNum 为空</td>
</tr>
<tr>
<td>-1542</td>
<td>车牌已存在</td>
</tr>
<tr>
<td>-1543</td>
<td>carColor 为空</td>
</tr>
<tr>
<td>-1544</td>
<td>parkingPlace为空</td>
</tr>
<tr>
<td>-1551</td>
<td>oldCardId 为空</td>
</tr>
<tr>
<td>-1552</td>
<td>oldCardId 不存在</td>
</tr>
<tr>
<td>-1553</td>
<td>newCardId 为空</td>
</tr>
<tr>
<td>-1554</td>
<td>newCardId 已存在</td>
</tr>
<tr>
<td>-1601</td>
<td>userId 为空</td>
</tr>
<tr>
<td>-1602</td>
<td>userId 不存在</td>
</tr>
<tr>
<td>-1701</td>
<td>boxId 为空</td>
</tr>
<tr>
<td>-1702</td>
<td>boxId 不存在</td>
</tr>
<tr>
<td>-1711</td>
<td>boxDoorsRight 为空</td>
</tr>
<tr>
<td>-1712</td>
<td>boxDoorsRight 错误</td>
</tr>
<tr>
<td>-1713</td>
<td>boxName为空</td>
</tr>
<tr>
<td>-1714</td>
<td>boxName重复</td>
</tr>
<tr>
<td>-1715</td>
<td>boxLocation为空</td>
</tr>
<tr>
<td>-1716</td>
<td>box status格式有误</td>
</tr>
<tr>
<td>-1717</td>
<td>box status为空</td>
</tr>
<tr>
<td>-1718</td>
<td>该岗亭下的岗亭口被使用</td>
</tr>
<tr>
<td>-1721</td>
<td>boxDoorId 为空</td>
</tr>
<tr>
<td>-1722</td>
<td>boxDoorId 不存在</td>
</tr>
<tr>
<td>-1723</td>
<td>boxDoorName为空</td>
</tr>
<tr>
<td>-1724</td>
<td>boxDoorName重复</td>
</tr>
<tr>
<td>-1725</td>
<td>boxDoor function为空</td>
</tr>
<tr>
<td>-1726</td>
<td>boxDoor function格式有误</td>
</tr>
<tr>
<td>-1727</td>
<td>boxDoor type为空</td>
</tr>
<tr>
<td>-1728</td>
<td>boxDoor type格式有误</td>
</tr>
<tr>
<td>-1729</td>
<td>boxDoor status为空</td>
</tr>
<tr>
<td>-1730</td>
<td>boxDoor status格式有误</td>
</tr>
<tr>
<td>-1731</td>
<td>boxDoor被使用</td>
</tr>
<tr>
<td>-1732</td>
<td>boxCompId 有误</td>
</tr>
<tr>
<td>-1733</td>
<td>isCheck 格式有误</td>
</tr>
<tr>
<td>-1734</td>
<td>isTempIn 格式有误</td>
</tr>
<tr>
<td>-1735</td>
<td>isTempOut 格式有误</td>
</tr>
<tr>
<td>-1736</td>
<td>cardRights 格式有误</td>
</tr>
<tr>
<td>-1801</td>
<td>deviceId 为空</td>
</tr>
<tr>
<td>-1802</td>
<td>deviceId 不存在</td>
</tr>
<tr>
<td>-1803</td>
<td>deviceId 正在使用中</td>
</tr>
<tr>
<td>-1804</td>
<td>deviceName 为空</td>
</tr>
<tr>
<td>-1805</td>
<td>deviceName 重复</td>
</tr>
<tr>
<td>-1806</td>
<td>deviceIP 为空</td>
</tr>
<tr>
<td>-1807</td>
<td>deviceIP 格式有误</td>
</tr>
<tr>
<td>-1808</td>
<td>deviceMac 为空</td>
</tr>
<tr>
<td>-1809</td>
<td>deviceMac 格式有误</td>
</tr>
<tr>
<td>-1810</td>
<td>deviceType 为空</td>
</tr>
<tr>
<td>-1811</td>
<td>deviceType 格式有误</td>
</tr>
</tbody>
</table>


</body>

</html>
