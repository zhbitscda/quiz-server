<!DOCTYPE html><html>

<head>
<meta charset="utf-8">
<title>中央处理器逻辑后台接口设计</title>
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
<h2 id="toc_0">中央处理器逻辑后台接口文档</h2>

<ul>
<li><a href="#protocol_base">协议基础</a></li>
<li><a href="#base_module">基础模块</a></li>
<li><a href="#operator_module">操作员模块</a></li>
<li><a href="#role_module">角色模块</a></li>
<li><a href="#permission_module">权限模块</a></li>
<li><a href="#user_module">用户模块</a></li>
<li><a href="#car_module">车辆管理模块</a></li>
<li><a href="#card_module">卡片模块</a></li>
<li><a href="#box_module">岗亭模块</a></li>
<li><a href="#device_module">设备模块</a></li>
<li><a href="#report_module">报表模块</a></li>
<li><a href="#admission_module">车辆出入模块</a></li>
<li><a href="#config_module">配置模块</a></li>
<li><a href="#pay_module">收费模块</a></li>
<li><a href="#cloud_module">云平台模块</a></li>
<li><a href="#error_and_update_doc">历史更新说明和错误码</a></li>
</ul>

<p><a name="protocol_base"></a></p>

<h2 id="toc_1">协议基础</h2>

<h3 id="toc_2">公共传入参数:</h3>

<ul>
<li>”ver“:协议版本号</li>
<li>“tk”:”token值”</li>
<li>”ts“ : “请求时的时间戳”</li>
</ul>

<h3 id="toc_3">公共返回参数:</h3>

<ul>
<li>“ret” : “响应码”,</li>
<li>“errMsg” : “错误描述”</li>
</ul>

<h3 id="toc_4">注意</h3>

<ul>
<li>使用 CORS 解决跨域问题<a href="https://github.com/vluzrmos/lumen-cors">库地址</a></li>
</ul>

<p><a name="base_module"></a></p>

<h2 id="toc_5">基础模块(base)</h2>

<h3 id="toc_6">获取导航栏数据(Finished)</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/navigation</p>

<p>响应参数：</p>

<pre><code class="language-none">{
    &quot;ret&quot; : 0,
    &quot;data&quot; : [
        {
          &quot;name&quot;: &quot;操作员管理&quot;,
          &quot;subMenu&quot;: [
            {
              &quot;name&quot;: &quot;操作员用户&quot;,
              &quot;url&quot;: &quot;Operator/operator_users.html&quot;
            },
            {
              &quot;name&quot;: &quot;操作员权限&quot;,
              &quot;url&quot;: &quot;Operator/operator_permissions.html&quot;
            }
          ]
        },
        {
          &quot;name&quot;: &quot;卡片管理&quot;,
          &quot;subMenu&quot;: [
            {
              &quot;name&quot;: &quot;卡片发行&quot;,
              &quot;url&quot;: &quot;Card/card_issuance.html&quot;
            },
            {
              &quot;name&quot;: &quot;卡片维护&quot;,
              &quot;url&quot;: &quot;Card/card_maintenance.html&quot;
            }
          ]
        },
        ...
    ]
}</code></pre>

<p><a name="operator_module"></a></p>

<h2 id="toc_7">操作员模块(operator)</h2>

<h3 id="toc_8">查看操作员(Finished)</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/operator?id=123&amp;page=123&amp;perPage=123</p>

<h4 id="toc_9">不带 id 参数时,获取列表</h4>

<p>响应参数：</p>

<pre><code class="language-none">登录成功：
{
    &quot;ret&quot; : 0,
    /* 分页信息仅当含有page参数时提供 */
    &quot;total&quot;: 总共的数量,
    &quot;perPage&quot;: 每页显示的数量,
    &quot;currentPage&quot;: 当前页码,
    &quot;lastPage&quot;: 最后一页页码,
    &quot;nextPageUrl&quot;: 下一页URL(如果不存在则为null),
    &quot;prevPageUrl&quot;: 上一页URL(如果不存在则为null),
    /* 分页信息尾部 */
    &quot;data&quot; :
    [
        {
            &quot;operatorId&quot; : (操作者ID),
            &quot;name&quot; : (操作者姓名),
            &quot;roleId&quot; : (角色ID),
            &quot;createdDate&quot; : (创建时间),
            &quot;updatedDate&quot; : (更新时间)
        },
        {
            &quot;operatorId&quot; : (操作者ID),
            &quot;name&quot; : (操作者姓名),
            &quot;roleId&quot; : (角色ID),
            &quot;createdDate&quot; : (创建时间),
            &quot;updatedDate&quot; : (更新时间)
        },
        ...
    ]
    &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h4 id="toc_10">带 id 参数时，获取对应操作员</h4>

<p>响应参数：</p>

<pre><code class="language-none">登录成功：
{
    &quot;ret&quot; : 0,
    &quot;data&quot; :
    {
        &quot;operatorId&quot; : (操作者ID),
        &quot;name&quot; : (操作者姓名),
        &quot;roleId&quot; : (角色ID),
        &quot;createdDate&quot; : (创建时间),
        &quot;updatedDate&quot; : (更新时间)
    },
    &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h3 id="toc_11">操作者登录(Finished)</h3>

<p>地址：<code>POST</code> http://120.76.155.35:8080/operator/login</p>

<p>请求参数：</p>

<pre><code class="language-none">{
    &quot;userName&quot;: &quot;&quot;,
    &quot;password&quot;: &quot;&quot;,
}</code></pre>

<p>响应参数：</p>

<pre><code class="language-none">登录成功：
{
    &quot;ret&quot; : 0,
    &quot;data&quot; : {
        &quot;accessToken&quot; : 123456789
        &quot;operatorId&quot; : (操作者Id)
    }
    &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h3 id="toc_12">操作者注销(返回假数据)</h3>

<p>地址：<code>POST</code> http://120.76.155.35:8080/operator/logout</p>

<p>请求参数：</p>

<pre><code class="language-none">{
    &quot;accessToken&quot; : 123456789
}</code></pre>

<p>响应参数：</p>

<pre><code class="language-none">登录成功：
{
    &quot;ret&quot; : 0,
    &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h3 id="toc_13">新增操作员(Finished)</h3>

<p>地址：<code>POST</code> http://120.76.155.35:8080/operator</p>

<p>请求参数：</p>

<pre><code class="language-none">{
    &quot;accessToken&quot; : 123456789(必填),
    &quot;name&quot;: &quot;test&quot;(操作者账号,必填),
    &quot;password&quot;: &quot;test&quot;(密码,必填),
    &quot;roleId&quot;: 1(角色Id,必填),
}</code></pre>

<p>响应参数：</p>

<pre><code class="language-none">新增成功：
{
    &quot;ret&quot; : 0,
    &quot;data&quot; : {
        &quot;operatorId&quot; : &quot;操作者Id&quot;
    },
    &quot;errMsge&quot;: &quot;&quot;
}</code></pre>

<h3 id="toc_14">修改操作员(Finished)</h3>

<p>地址：<code>PUT</code> http://120.76.155.35:8080/operator</p>

<p>请求参数：</p>

<pre><code class="language-none">{
    &quot;accessToken&quot; : 123456789(必填),
    &quot;operatorId&quot; : (操作者ID,必填),
    &quot;name&quot; : (操作者账号,选填),
    &quot;password&quot;: (密码,选填),
    &quot;roleId&quot;: 1(角色Id,选填),
    ...
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_15">删除操作员(Finished)</h3>

<p>地址：<code>DELETE</code> http://120.76.155.35:8080/operator</p>

<p>请求参数：</p>

<pre><code class="language-none">{
   &quot;accessToken&quot; : 123456789,
    &quot;operatorId&quot; : (操作者ID,必填)
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<p><a name="role_module"></a></p>

<h2 id="toc_16">角色模块(role)</h2>

<h3 id="toc_17">查看角色(Finished)</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/role?id=123&amp;page=123&amp;perPage=123</p>

<h4 id="toc_18">不带 id 参数时,获取列表</h4>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
      /* 分页信息仅当含有page参数时提供 */
      &quot;total&quot;: 总共的数量,
      &quot;perPage&quot;: 每页显示的数量,
      &quot;currentPage&quot;: 当前页码,
      &quot;lastPage&quot;: 最后一页页码,
      &quot;nextPageUrl&quot;: 下一页URL(如果不存在则为null),
      &quot;prevPageUrl&quot;: 上一页URL(如果不存在则为null),
      /* 分页信息尾部 */
     &quot;data&quot; :
     [
        {
            &quot;roleId&quot; : 123,
            &quot;name&quot; : 名称,
            &quot;desc&quot; : 描述,
            &quot;permissions&quot; :
            [
                {
                    &quot;permissionId&quot; : 1,
                    &quot;name&quot; : 名称,
                    &quot;desc&quot; : 描述,
                    &quot;parentId&quot; : 父Id(若无则输出null)
                },
                {
                    &quot;permissionId&quot; : 2,
                    &quot;name&quot; : 名称,
                    &quot;desc&quot; : 描述,
                    &quot;parentId&quot; : 父Id(若无则输出null)
                },
                ...
            ]
            &quot;createdDate&quot; : 创建时间,
            &quot;updatedDate&quot; : 更新时间
        },
        {
            &quot;roleId&quot; : 123,
            &quot;name&quot; : 名称,
            &quot;desc&quot; : 描述,
            &quot;permissions&quot; :
            [
                {
                    &quot;permissionId&quot; : 1,
                    &quot;name&quot; : 名称,
                    &quot;desc&quot; : 描述,
                    &quot;parentId&quot; : 父Id(若无则输出null)
                },
                {
                    &quot;permissionId&quot; : 2,
                    &quot;name&quot; : 名称,
                    &quot;desc&quot; : 描述,
                    &quot;parentId&quot; : 父Id(若无则输出null)
            },
            ...
        ]
        &quot;createdDate&quot; : 创建时间,
        &quot;updatedDate&quot; : 更新时间
        },
        ...
     ],
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h4 id="toc_19">带 id 参数时，获取对应权限</h4>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : {
        &quot;id&quot; : 123,
        &quot;name&quot; : 名称,
        &quot;desc&quot; : 描述,
        &quot;permissions&quot; :
        [
            {
                &quot;id&quot; : 1,
                &quot;name&quot; : 名称,
                &quot;desc&quot; : 描述,
                &quot;parentId&quot; : 父Id(若无则输出null)
            },
            {
                &quot;id&quot; : 2,
                &quot;name&quot; : 名称,
                &quot;desc&quot; : 描述,
                &quot;parentId&quot; : 父Id(若无则输出null)
            },
            ...
        ]
        &quot;createdDate&quot; : 创建时间,
        &quot;updatedDate&quot; : 更新时间
     }
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_20">添加角色(Finished)</h3>

<p>地址：<code>POST</code> http://120.76.155.35:8080/role</p>

<p>请求参数：</p>

<pre><code class="language-none">{
    &quot;accessToken&quot; : 123456789,
    &quot;roleName&quot; : (角色名,必填),
    &quot;desc&quot; : (描述, 选填),
    &quot;permissions&quot; : [1,2,3,4,5](权限,必填),
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : {
        &quot;roleId&quot; : &quot;角色Id&quot;
    },
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_21">修改角色(Finished)</h3>

<p>地址：<code>PUT</code> http://120.76.155.35:8080/role</p>

<p>请求参数：</p>

<pre><code class="language-none">{
    &quot;accessToken&quot; : 123456789,(必填),
    &quot;roleId&quot;   : (角色ID,必填),
    &quot;roleName&quot; : (角色名,必填),
    &quot;desc&quot; : (描述, 选填),
    &quot;permissions&quot; : [1,2,3,4,5](权限, 选填)
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_22">删除角色(Finished)</h3>

<p>地址：<code>DELETE</code> http://120.76.155.35:8080/role</p>

<p>请求参数：</p>

<pre><code class="language-none">{
    &quot;accessToken&quot; : 123456789,
    &quot;roleId&quot; : (角色ID,必填)
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<p><a name="permission_module"></a></p>

<h2 id="toc_23">权限模块(permission_module)</h2>

<h3 id="toc_24">查看权限(Finished)</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/permissionid=123&amp;page=123&amp;perPage=123</p>

<h4 id="toc_25">不带 id 参数时,获取列表</h4>

<p>返回结果：</p>

<pre><code class="language-none">{
  &quot;ret&quot;: 0,
  /* 分页信息仅当含有page参数时提供 */
  &quot;total&quot;: 总共的数量,
  &quot;perPage&quot;: 每页显示的数量,
  &quot;currentPage&quot;: 当前页码,
  &quot;lastPage&quot;: 最后一页页码,
  &quot;nextPageUrl&quot;: 下一页URL(如果不存在则为null),
  &quot;prevPageUrl&quot;: 上一页URL(如果不存在则为null),
  /* 分页信息尾部 */
  &quot;data&quot;: [
    {
      &quot;permissionId&quot;: 1,
      &quot;name&quot;: 权限名称,
      &quot;desc&quot;: 描述,
      &quot;parentId&quot; : 父Id(若无则输出null)
    },
    {
      &quot;permissionId&quot;: 2,
      &quot;name&quot;: 权限名称,
      &quot;desc&quot;: 描述,
      &quot;parentId&quot; : 父Id(若无则输出null)
    }
  ],
  &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h4 id="toc_26">带 id 参数时，获取对应权限</h4>

<p>返回结果：</p>

<pre><code class="language-none">{
  &quot;ret&quot;: 0,
  &quot;data&quot;:{
      &quot;permissionId&quot;: 1,
      &quot;name&quot;: 权限名称,
      &quot;desc&quot;: 描述,
      &quot;parentId&quot; : 父Id(若无则输出null)
  },
  &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<p><a name="user_module"></a></p>

<h2 id="toc_27">用户模块(user)</h2>

<h3 id="toc_28">获取用户列表(Finished)</h3>

<h4 id="toc_29">不带 id 参数时,获取列表</h4>

<p>地址：<code>GET</code> http://120.76.155.35:8080/user?id=123&amp;page=123&amp;perPage=123</p>

<p>返回结果：</p>

<pre><code class="language-none">{
  &quot;ret&quot;: 0,
  /* 分页信息仅当含有page参数时提供 */
  &quot;total&quot;: 总共的数量,
  &quot;perPage&quot;: 每页显示的数量,
  &quot;currentPage&quot;: 当前页码,
  &quot;lastPage&quot;: 最后一页页码,
  &quot;nextPageUrl&quot;: 下一页URL(如果不存在则为null),
  &quot;prevPageUrl&quot;: 上一页URL(如果不存在则为null),
  /* 分页信息尾部 */
  &quot;data&quot;: [
    {
      &quot;userId&quot;: 1,
      &quot;name&quot;: &quot;小明&quot;,
      &quot;telephone&quot;: &quot;13000000000&quot;,
      &quot;homephone&quot;: &quot;010-80000000&quot;,
      &quot;idCard&quot;: &quot;330726196507040016&quot;,
      &quot;birthday&quot;: &quot;1990&quot;,
      &quot;address&quot;: &quot;北京市复兴门内大街1号&quot;,
      &quot;department&quot;: 部门,
      &quot;photoUrl&quot;: &quot;https://ss2.baidu.com/6ONYsjip0QIZ8tyhnq/it/u=1145593724,4003588733&amp;fm=58&quot;
     },
    {
      &quot;userId&quot;: 2,
      &quot;name&quot;: &quot;小红&quot;,
      &quot;telephone&quot;: &quot;13000000001&quot;,
      &quot;homephone&quot;: &quot;010-80000001&quot;,
      &quot;idCard&quot;: &quot;430421197710177894&quot;,
      &quot;birthday&quot;: &quot;631123200&quot;,
      &quot;address&quot;: &quot;北京市复兴门内大街2号&quot;,
      &quot;department&quot;: 部门,
      &quot;photoUrl&quot;: &quot;https://ss1.baidu.com/6ONXsjip0QIZ8tyhnq/it/u=523395346,19022666&amp;fm=58&quot;
    },
     ...
  ],
  &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h4 id="toc_30">带 id 参数时，获取对应权限</h4>

<p>返回结果：</p>

<pre><code class="language-none">{
  &quot;ret&quot;: 0,
  &quot;data&quot;:{
      &quot;userId&quot;: 2,
      &quot;name&quot;: &quot;小红&quot;,
      &quot;telephone&quot;: &quot;13000000001&quot;,
      &quot;homephone&quot;: &quot;010-80000001&quot;,
      &quot;idCard&quot;: &quot;430421197710177894&quot;,
      &quot;birthday&quot;: &quot;631123200&quot;,
      &quot;address&quot;: &quot;北京市复兴门内大街2号&quot;,
      &quot;department&quot;: 部门,
      &quot;photoUrl&quot;: &quot;https://ss1.baidu.com/6ONXsjip0QIZ8tyhnq/it/u=523395346,19022666&amp;fm=58&quot;
  },
  &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h3 id="toc_31">添加用户</h3>

<p>地址：<code>POST</code> http://120.76.155.35:8080/user</p>

<p>请求参数：</p>

<pre><code class="language-none">{
    &quot;name&quot;: 用户名,
    &quot;telephone&quot;: 手机号码,
    &quot;homephone&quot;: 座机号码,
    &quot;idCard&quot;: 身份证号码,
    &quot;birthday&quot;: 生日(时间戳),
    &quot;department&quot; : 部门,
    &quot;address&quot;: 地址,
    &quot;photoUrl&quot;: 图片URL
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : {
        &quot;userId&quot; : &quot;用户id&quot;
    },
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_32">修改用户</h3>

<p>地址：<code>PUT</code> http://120.76.155.35:8080/user</p>

<p>请求参数：</p>

<pre><code class="language-none">{
    &quot;userId&quot; : 用户ID,
    &quot;name&quot;: 用户名,
    &quot;telephone&quot;: 手机号码,
    &quot;homephone&quot;: 座机号码,
    &quot;idCard&quot;: 身份证号码,
    &quot;birthday&quot;: 生日(时间戳),
    &quot;department&quot; : 部门,
    &quot;address&quot;: 地址,
    &quot;photoUrl&quot;: 图片URL
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : &quot;&quot;
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_33">删除用户</h3>

<p>地址：<code>DELETE</code> http://120.76.155.35:8080/user</p>

<p>请求参数：</p>

<pre><code class="language-none">{
      &quot;userId&quot;: (ID,必填)
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : &quot;&quot;
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_34">获取未派发用户列表(Finished)</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/user/notIssueParkCard?id=123&amp;page=123&amp;perPage=123&amp;search=小明</p>

<p>返回结果：</p>

<pre><code class="language-none">{
  &quot;ret&quot;: 0,
  /* 分页信息仅当含有page参数时提供 */
  &quot;total&quot;: 总共的数量,
  &quot;perPage&quot;: 每页显示的数量,
  &quot;currentPage&quot;: 当前页码,
  &quot;lastPage&quot;: 最后一页页码,
  &quot;nextPageUrl&quot;: 下一页URL(如果不存在则为null),
  &quot;prevPageUrl&quot;: 上一页URL(如果不存在则为null),
  /* 分页信息尾部 */
  &quot;data&quot;: [
    {
      &quot;userId&quot;: 1,
      &quot;name&quot;: &quot;小明&quot;,
      &quot;telephone&quot;: &quot;13000000000&quot;,
      &quot;homephone&quot;: &quot;010-80000000&quot;,
      &quot;idCard&quot;: &quot;330726196507040016&quot;,
      &quot;birthday&quot;: &quot;1990&quot;,
      &quot;address&quot;: &quot;北京市复兴门内大街1号&quot;,
      &quot;department&quot;: 部门,
      &quot;photoUrl&quot;: &quot;https://ss2.baidu.com/6ONYsjip0QIZ8tyhnq/it/u=1145593724,4003588733&amp;fm=58&quot;
     },
    {
      &quot;userId&quot;: 2,
      &quot;name&quot;: &quot;小红&quot;,
      &quot;telephone&quot;: &quot;13000000001&quot;,
      &quot;homephone&quot;: &quot;010-80000001&quot;,
      &quot;idCard&quot;: &quot;430421197710177894&quot;,
      &quot;birthday&quot;: &quot;631123200&quot;,
      &quot;address&quot;: &quot;北京市复兴门内大街2号&quot;,
      &quot;department&quot;: 部门,
      &quot;photoUrl&quot;: &quot;https://ss1.baidu.com/6ONXsjip0QIZ8tyhnq/it/u=523395346,19022666&amp;fm=58&quot;
    },
     ...
  ],
  &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h3 id="toc_35">搜索用户列表(Finished)</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/user/search</p>

<p>请求参数：</p>

<pre><code class="language-none">{
    &quot;userName&quot; : 用户名,
    &quot;isNotIssue&quot; : 是否要查询未发卡用户(1:是),
    &quot;department&quot; : 部门名称,
    &quot;carNo&quot; : 车牌号码,
    &quot;id&quot; : 编号,
    &quot;telephone&quot; : 电话号码
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{

}</code></pre>

<h3 id="toc_36">获取部门数据(Finished)</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/user/department</p>

<p>返回结果：</p>

<pre><code class="language-none">{
  &quot;ret&quot;: 0,
  &quot;data&quot;: [
    &quot;市场部&quot;,
    &quot;技术部&quot;,
    &quot;设计部&quot;
  ],
  &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<p><a name="car_module"></a></p>

<h2 id="toc_37">车辆管理模块(car)</h2>

<h3 id="toc_38">查看车辆(Finished)</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/car?id=123&amp;page=123&amp;perPage=123</p>

<p>请求参数:</p>

<pre><code class="language-none">{
    /* 传 id 获取单个信息*/
   &quot;id&quot; : 123,
   /* 传车牌获取车辆信息 */
   &quot;carLocId&quot; : 区域ID,
   &quot;carNum&quot; : 车牌号码,
   /* 分页 */
   &quot;page&quot;: 1,
   &quot;perPage&quot; : 10,
}</code></pre>

<h4 id="toc_39">不带 id 参数时,获取列表</h4>

<p>返回结果：</p>

<pre><code class="language-none">{
  &quot;ret&quot;: 0,
  /* 分页信息仅当含有page参数时提供 */
  &quot;total&quot;: 总共的数量,
  &quot;perPage&quot;: 每页显示的数量,
  &quot;currentPage&quot;: 当前页码,
  &quot;lastPage&quot;: 最后一页页码,
  &quot;nextPageUrl&quot;: 下一页URL(如果不存在则为null),
  &quot;prevPageUrl&quot;: 上一页URL(如果不存在则为null),
  /* 分页信息尾部 */
  &quot;data&quot;: [
    {
      &quot;carId&quot;: 1,
      &quot;carLocId&quot;: 车牌所属地Id,
      &quot;carLocName&quot;: 车牌所属地名称,
      &quot;carNum&quot;: 车牌号码,
      &quot;carId&quot;: 车ID,
      &quot;carTypeId&quot;: 车型Id,
      &quot;carTypeName&quot;: 车型名称,
      &quot;parkingPlace&quot;: 车位,
      &quot;carColor&quot;: 车颜色,
      &quot;carPhotoId&quot;: 车相片Id,
      &quot;carPhotoUrl&quot;: 车相片URL,   
      &quot;created_at&quot;: 创建时间,
      &quot;updated_at&quot;: 更新时间
    },
    {
      &quot;carId&quot;: 2,
      &quot;carLocId&quot;: 车牌所属地Id,
      &quot;carLocName&quot;: 车牌所属地名称,
      &quot;carNum&quot;: 车牌号码,
      &quot;carId&quot;: 车ID,
      &quot;carTypeId&quot;: 车型Id,
      &quot;carTypeName&quot;: 车型名称,
      &quot;parkingPlace&quot;: 车位,
      &quot;carColor&quot;: 车颜色,
      &quot;carPhotoId&quot;: 车相片Id,
      &quot;carPhotoUrl&quot;: 车相片URL,   
      &quot;created_at&quot;: 创建时间,
      &quot;updated_at&quot;: 更新时间
    }
  ],
  &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h4 id="toc_40">带 id 参数时，获取对应权限</h4>

<p>返回结果：</p>

<pre><code class="language-none">{
  &quot;ret&quot;: 0,
  &quot;data&quot;:{
      &quot;carId&quot;: 1,
      &quot;carLocId&quot;: 车牌所属地Id,
      &quot;carLocName&quot;: 车牌所属地名称,
      &quot;carNum&quot;: 车牌号码,
      &quot;carId&quot;: 车ID,
      &quot;carTypeId&quot;: 车型Id,
      &quot;carTypeName&quot;: 车型名称,
      &quot;parkingPlace&quot;: 车位,
      &quot;carColor&quot;: 车颜色,
      &quot;carPhotoId&quot;: 车相片Id,
      &quot;carPhotoUrl&quot;: 车相片URL,   
      &quot;created_at&quot;: 创建时间,
      &quot;updated_at&quot;: 更新时间
  },
  &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h3 id="toc_41">搜索车辆列表(Finished)</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/car/search</p>

<p>请求参数：</p>

<pre><code class="language-none">{
    &quot;carLocId&quot; : 归属地Id,
    &quot;carNum&quot; : 车牌号
}</code></pre>

<p>响应参数：</p>

<pre><code class="language-none">{
    车辆信息和查看接口一样
}</code></pre>

<p><a name="card_module"></a></p>

<h2 id="toc_42">卡片管理模块（card）</h2>

<h3 id="toc_43">停车卡</h3>

<h3 id="toc_44">查看停车卡</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/card/parkCard?id=123&amp;page=123&amp;perPage=123</p>

<h4 id="toc_45">不带 id 参数时,获取列表</h4>

<p>返回结果：</p>

<pre><code class="language-none">{
  &quot;ret&quot;: 0,
  /* 分页信息仅当含有page参数时提供 */
  &quot;total&quot;: 总共的数量,
  &quot;perPage&quot;: 每页显示的数量,
  &quot;currentPage&quot;: 当前页码,
  &quot;lastPage&quot;: 最后一页页码,
  &quot;nextPageUrl&quot;: 下一页URL(如果不存在则为null),
  &quot;prevPageUrl&quot;: 上一页URL(如果不存在则为null),
  /* 分页信息尾部 */
  &quot;data&quot;: [
  {
      &quot;cardId&quot;: 卡号,
      &quot;userId&quot;: 用户ID,
      &quot;userName&quot;: 用户名,
      &quot;property&quot;: 属性(必填,0-ID,1-IC,2-纯车牌),
      &quot;deposit&quot;: 押金,
      &quot;printNo&quot;: 印刷号(通常是指印刷在卡上的信息),
      &quot;cardTypeId&quot;: 停车卡类型Id,
      &quot;cardTypeName&quot;: 停车卡类型名,
      &quot;times&quot;: 次数,
      &quot;balance&quot;: 余额,
      &quot;boxDoorsRight&quot;: [1,2,3](岗亭口ID,列表),
      &quot;isNote&quot;: 短信功能(0-关闭,1-开启),
      &quot;remark&quot;: 备注,
      &quot;carNum&quot;: 车牌号码,
      &quot;carId&quot;: 车ID,
      &quot;carType&quot;: 车型,
      &quot;parkingPlace&quot;: 车位,
      &quot;beginDate&quot;: 开始使用日期,
      &quot;endDate&quot;: 结束使用日期,
      &quot;status&quot;: 卡状态(0-正常,1-挂失,2-停用)
   },
   {
      &quot;cardId&quot;: 卡号,
      &quot;userId&quot;: 用户ID,
      &quot;userName&quot;: 用户名,
      &quot;property&quot;: 属性(必填,0-ID,1-IC,2-纯车牌),
      &quot;deposit&quot;: 押金,
      &quot;printNo&quot;: 印刷号(通常是指印刷在卡上的信息),
      &quot;cardTypeId&quot;: 停车卡类型Id,
      &quot;cardTypeName&quot;: 停车卡类型名,
      &quot;times&quot;: 次数,
      &quot;balance&quot;: 余额,
      &quot;boxDoorsRight&quot;: [1,2,3](岗亭口ID，列表),
      &quot;isNote&quot;: 短信功能(0-关闭,1-开启),
      &quot;remark&quot;: 备注,
      &quot;carNum&quot;: 车牌号码,
      &quot;carId&quot;: 车ID,
      &quot;carType&quot;: 车型,
      &quot;parkingPlace&quot;: 车位,
      &quot;beginDate&quot;: 开始使用日期,
      &quot;endDate&quot;: 结束使用日期,
      &quot;status&quot;: 卡状态(0-正常,1-挂失,2-停用)
   },
   ...
   ],
   &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h4 id="toc_46">带 id 参数时,获取对应停车卡</h4>

<p>返回结果：</p>

<pre><code class="language-none">{
  &quot;ret&quot;: 0,
  &quot;data&quot;: {
      &quot;cardId&quot;: 卡号,
      &quot;userId&quot;: 用户ID,
      &quot;userName&quot;: 用户名,
      &quot;property&quot;: 属性(必填,0-ID,1-IC,2-纯车牌),
      &quot;deposit&quot;: 押金,
      &quot;printNo&quot;: 印刷号(通常是指印刷在卡上的信息),
      &quot;cardTypeId&quot;: 停车卡类型Id,
      &quot;cardTypeName&quot;: 停车卡类型名,
      &quot;times&quot;: 次数,
      &quot;balance&quot;: 余额,
      &quot;boxDoorsRight&quot;: [1,2,3](岗亭口ID，列表),
      &quot;isNote&quot;: 短信功能(0-关闭,1-开启),
      &quot;remark&quot;: 备注,
      &quot;carNum&quot;: 车牌号码,
      &quot;carId&quot;: 车ID,
      &quot;carType&quot;: 车型,
      &quot;parkingPlace&quot;: 车位,
      &quot;beginDate&quot;: 开始使用日期,
      &quot;endDate&quot;: 结束使用日期,
      &quot;status&quot;: 卡状态(0-正常,1-挂失,2-停用)
   },
   &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h3 id="toc_47">添加停车卡</h3>

<p>地址：<code>POST</code> http://120.76.155.35:8080/card/parkCard</p>

<p>请求参数：</p>

<pre><code class="language-none">{
      &quot;cardId&quot;: 卡号(必填,物理号),
      &quot;userId&quot;: 用户ID(必填),
      &quot;property&quot;: 属性(必填,0-ID,1-IC,2-纯车牌),
      &quot;deposit&quot;: 押金(选填,默认值为0),
      &quot;printNo&quot;: 印刷号(选填,通常是指印刷在卡上的信息),
      &quot;cardTypeId&quot;: 停车卡类型Id(必填),
      &quot;times&quot;: 次数(选填,仅在次卡需要填),
      &quot;balance&quot;: 余额(选填,默认值为0),
      &quot;boxDoorsRight&quot;: 发行权限(必填,多选,岗亭口ID)[1,2,3],
      &quot;isNote&quot;: 短信功能(选填,0-关闭,1-开启),
      &quot;remark&quot;: 备注(选填),
      &quot;carNum&quot;: 车牌号码(必填),
      &quot;carType&quot;: 车型,
      &quot;parkingPlace&quot;: 车位(选填),
      &quot;carId&quot;: 车ID(如果车牌存在,不存在则不用传),
      &quot;beginDate&quot;: 开始使用日期(选填,仅在月卡需要填),
      &quot;endDate&quot;: 结束使用日期(选填,仅在月卡需要填)
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : {
        &quot;cardId&quot; : &quot;卡Id&quot;
    },
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_48">修改停车卡</h3>

<p>地址：<code>PUT</code> http://120.76.155.35:8080/card/parkCard</p>

<p>请求参数：</p>

<pre><code class="language-none">{
      &quot;cardId&quot;: &quot;D00000000&quot;,
      &quot;userId&quot;: &quot;1&quot;,
      &quot;property&quot;: &quot;1&quot;,
      &quot;deposit&quot;: &quot;1000&quot;,
      &quot;printNo&quot;: &quot;印刷号02&quot;,
      &quot;cardTypeId&quot;: &quot;1&quot;,
      &quot;times&quot;: &quot;10&quot;,
      &quot;balance&quot;: &quot;100&quot;,
      &quot;amount&quot; : &quot;100&quot;,
      &quot;boxRight&quot;: [1,2,3,4],
      &quot;isNote&quot;: &quot;1&quot;,
      &quot;remark&quot;: &quot;备注01&quot;,
      &quot;carLocId&quot;: 3,
      &quot;carId&quot; : 3,
      &quot;carNum&quot;: &quot;京A00003&quot;,
      &quot;carTypeId&quot;: &quot;1&quot;,
      &quot;parkingPlace&quot;: &quot;A49&quot;,
      &quot;carColor&quot;: &quot;#990033&quot;,
      &quot;carPhotoId&quot;: &quot;2&quot;,
      &quot;beginDate&quot;: &quot;2014-07-21&quot;,
      &quot;endDate&quot;: &quot;2015-07-21&quot;,
      &quot;operatorId&quot;: 1
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : {
        &quot;cardId&quot; : &quot;卡Id&quot;
    },
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_49">删除停车卡</h3>

<p>地址：<code>DELETE</code> http://120.76.155.35:8080/card/parkCard</p>

<p>请求参数：</p>

<pre><code class="language-none">{
    &quot;accessToken&quot; : 123456789,
    &quot;cardId&quot; : (卡ID,必填)
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_50">获取发行需要的数据</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/card/issueParkCardData</p>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot;:{
          // 卡类型
          &quot;cardType&quot;:[
            {
                &quot;value&quot;: 卡类型Id,
                &quot;name&quot;: 卡类型名称
            },
            {
                &quot;value&quot;: 卡类型Id,
                &quot;name&quot;: 卡类型名称
            },
            ...
          ],
          // 原始卡类型(月租卡、储值卡等)
          &quot;cardOriType&quot;:[
            {
                &quot;value&quot;: 原始卡类型Id,
                &quot;name&quot;: 原始卡类型名称
            },
            {
                &quot;value&quot;: 原始卡类型Id,
                &quot;name&quot;: 原始卡类型名称
            },
            ...
          ],
          // 所有的月卡类型
          &quot;monthCard&quot;:[
            {
                &quot;value&quot;: 月卡类型Id,
                &quot;name&quot;: 月卡类型名称
            },
            {
                &quot;value&quot;: 月卡类型Id,
                &quot;name&quot;: 月卡类型名称
            },
            ...
          ],
          // 所有的储值卡类型
          &quot;storedCard&quot;:[
            {
                &quot;value&quot;: 储值卡类型Id,
                &quot;name&quot;: 储值卡类型名称
            },
            {
                &quot;value&quot;: 储值卡类型Id,
                &quot;name&quot;: 储值卡类型名称
            },
            ...
          ],
          // 所有的临时卡类型
          &quot;tempCard&quot;:[
            {
                &quot;value&quot;: 临时卡类型Id,
                &quot;name&quot;: 临时卡类型名称
            },
            {
                &quot;value&quot;: 临时卡类型Id,
                &quot;name&quot;: 临时卡类型名称
            },
            ...
          ],
          // 所有的贵宾卡类型
          &quot;vipCard&quot;:[
            {
                &quot;value&quot;: 贵宾卡类型Id,
                &quot;name&quot;: 贵宾卡类型名称
            },
            {
                &quot;value&quot;: 贵宾卡类型Id,
                &quot;name&quot;: 贵宾卡类型名称
            },
            ...
          ],
          // 所有的次卡类型
          &quot;timeCard&quot;:[
            {
                &quot;value&quot;: 次卡类型Id,
                &quot;name&quot;: 次卡类型名称
            },
            {
                &quot;value&quot;: 次卡类型Id,
                &quot;name&quot;: 次卡类型名称
            },
            ...
          ],
          // 所有卡属性
          &quot;property&quot;:[
            {
                &quot;value&quot;: 卡属性Id,
                &quot;name&quot;: 卡属性名称
            },
            {
                &quot;value&quot;: 卡属性Id,
                &quot;name&quot;: 卡属性名称
            },
            ...
          ],
          // 车牌所属地
          &quot;carLoc&quot;:[
            {
                &quot;value&quot;: 车牌所属地Id,
                &quot;name&quot;: 车牌所属地名称
            },
            {
                &quot;value&quot;: 车牌所属地Id,
                &quot;name&quot;: 车牌所属地名称
            },
            ...
          ],
          // 车型
          &quot;carType&quot;:[
            {
                &quot;value&quot;: 车型Id,
                &quot;name&quot;: 车型名称
            },
            {
                &quot;value&quot;: 车型Id,
                &quot;name&quot;: 车型名称
            },
            ...
          ],
          // 车图片
          &quot;carPhoto&quot;:[
            {
                &quot;value&quot;: 车图片Id,
                &quot;name&quot;: 车图片Url
            },
            {
                &quot;value&quot;: 车图片Id,
                &quot;name&quot;: 车图片Url
            },
            ...
          ]
     },
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_51">搜索停车卡列表(Finished)</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/card/parkCard/search</p>

<p>请求参数：</p>

<pre><code class="language-none">{
    &quot;cardId&quot; : 卡号,
    &quot;printNo&quot; : 印刷号,
    &quot;userId&quot; : 用户Id,
    &quot;userName&quot; : 用户名
    // 查询授权信息
    &quot;boxDoorId&quot;: 岗亭口Id
    &quot;isIssued&quot;: (填0为未授权，1为已授权)
}</code></pre>

<p>响应参数：</p>

<pre><code class="language-none">{
    停车卡信息和查看接口一样
}</code></pre>

<h3 id="toc_52">更换卡</h3>

<p>地址: <code>POST</code> http://120.76.155.35:8080/card/change</p>

<p>请求参数:</p>

<pre><code class="language-none">{
      &quot;oldCardId&quot;: &quot;12&quot;,
      &quot;newCardId&quot;: &quot;D0000000008&quot;
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_53">批量授权</h3>

<p>地址: <code>POST</code> http://120.76.155.35:8080/card/parkCard/license</p>

<p>请求参数:</p>

<pre><code class="language-none">{
    &quot;cards&quot;: [&quot;12&quot;,&quot;123&quot;],
    &quot;boxDoors&quot; : [&quot;1&quot;,&quot;3&quot;,&quot;4&quot;],
    &quot;type&quot;: (类型，0-新增授权，1-取消授权)
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<p><a name="box_module"></a></p>

<h2 id="toc_54">岗亭模块（box）</h2>

<h3 id="toc_55">获取岗亭信息</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/box?id=123&amp;page=123&amp;perPage=123</p>

<h4 id="toc_56">不带 id 参数时,获取列表</h4>

<p>响应参数：</p>

<pre><code class="language-none">登录成功：
{
    &quot;ret&quot; : 0,
    /* 分页信息仅当含有page参数时提供 */
    &quot;total&quot;: 总共的数量,
    &quot;perPage&quot;: 每页显示的数量,
    &quot;currentPage&quot;: 当前页码,
    &quot;lastPage&quot;: 最后一页页码,
    &quot;nextPageUrl&quot;: 下一页URL(如果不存在则为null),
    &quot;prevPageUrl&quot;: 上一页URL(如果不存在则为null),
    /* 分页信息尾部 */
    &quot;data&quot; :
    [
        {
          &quot;boxId&quot;: 岗亭ID,
          &quot;name&quot;: 岗亭名称,
          &quot;ip&quot;: ip地址,
          &quot;status&quot;: 岗亭状态(0-正常使用,1-停止使用),
          &quot;boxDoors&quot;: (对应的通道信息)
       },
       {
          &quot;boxId&quot;: 岗亭ID,
          &quot;name&quot;: 岗亭名称,
          &quot;ip&quot;: ip地址,
          &quot;status&quot;: 岗亭状态(0-正常使用,1-停止使用),
          &quot;boxDoors&quot;: (对应的通道信息)
       },
        ...
    ]
    &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h4 id="toc_57">带 id 参数时，获取对应数据</h4>

<p>响应参数：</p>

<pre><code class="language-none">登录成功：
{
    &quot;ret&quot; : 0,
    &quot;data&quot; :
    {
      &quot;boxDoorId&quot;: 岗亭口ID,
      &quot;name&quot;: 岗亭名称,
      &quot;ip&quot;: ip地址,
      &quot;status&quot;: 岗亭状态(0-正常使用,1-停止使用),
      &quot;boxDoors&quot;: (对应的通道信息)
   },
    &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h3 id="toc_58">添加岗亭</h3>

<p>地址：<code>POST</code> http://120.76.155.35:8080/box</p>

<p>请求参数：</p>

<pre><code class="language-none">{
      &quot;name&quot;: 名称,
      &quot;ip&quot;: ip地址,
      &quot;status&quot;: 岗亭状态(0-正常使用,1-停止使用)
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : {
        &quot;boxId&quot; : &quot;岗亭Id&quot;
    },
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_59">修改岗亭</h3>

<p>地址：<code>PUT</code> http://120.76.155.35:8080/box</p>

<p>请求参数：</p>

<pre><code class="language-none">{
      &quot;boxId&quot;: (ID,必填),
     &quot;name&quot;: (名称,选填),
     &quot;ip&quot;: ip地址,
     &quot;status&quot;: 岗亭状态(0-正常使用,1-停止使用)
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : &quot;&quot;
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_60">删除岗亭</h3>

<p>地址：<code>DELETE</code> http://120.76.155.35:8080/box</p>

<p>请求参数：</p>

<pre><code class="language-none">{
      &quot;boxId&quot;: (ID,必填)
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : &quot;&quot;
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_61">获取通道信息</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/box/boxDoor?id=123&amp;page=123&amp;perPage=123</p>

<h4 id="toc_62">不带 id 参数时,获取列表</h4>

<p>响应参数：</p>

<pre><code class="language-none">登录成功：
{
    &quot;ret&quot; : 0,
    /* 分页信息仅当含有page参数时提供 */
    &quot;total&quot;: 总共的数量,
    &quot;perPage&quot;: 每页显示的数量,
    &quot;currentPage&quot;: 当前页码,
    &quot;lastPage&quot;: 最后一页页码,
    &quot;nextPageUrl&quot;: 下一页URL(如果不存在则为null),
    &quot;prevPageUrl&quot;: 上一页URL(如果不存在则为null),
    /* 分页信息尾部 */
    &quot;data&quot; :
    [
        {
          &quot;boxDoorId&quot;: 通道ID,
          &quot;boxId&quot;: 岗亭ID,
          &quot;name&quot;: 通道名称,
          &quot;isCheck&quot;: 是否为监测口,
          &quot;isTempIn&quot;: 是否为临时入口,
          &quot;isTempOut&quot;: 是否为临时出口,
          &quot;cardRights&quot;: 卡类型权限列表,多选,
          &quot;devices&quot;: 通道对应的设备列表,多选,
          &quot;type&quot;: 通道类型(0-大车场,1-小车场),
          &quot;function&quot;: 通道作用(0-入,1-出),
          &quot;mainControlMachine&quot; : 主控制器机号,
          &quot;barrierGateControlMachine&quot; : 道闸控制器机号
          &quot;status&quot;: 通道状态(0-正常使用,1-停止使用)
     },
       {
          &quot;boxDoorId&quot;: 通道ID,
          &quot;boxId&quot;: 岗亭ID,
          &quot;name&quot;: 通道名称,
          &quot;isCheck&quot;: 是否为监测口,
          &quot;isTempIn&quot;: 是否为临时入口,
          &quot;isTempOut&quot;: 是否为临时出口,
          &quot;cardRights&quot;: 卡类型权限列表,多选,
          &quot;devices&quot;: 通道对应的设备列表,多选,
          &quot;type&quot;: 通道类型(0-大车场,1-小车场),
          &quot;function&quot;: 通道作用(0-入,1-出),
          &quot;mainControlMachine&quot; : 主控制器机号,
          &quot;barrierGateControlMachine&quot; : 道闸控制器机号
          &quot;status&quot;: 通道状态(0-正常使用,1-停止使用)
     },
        ...
    ]
    &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h4 id="toc_63">带 id 参数时，获取对应数据</h4>

<p>响应参数：</p>

<pre><code class="language-none">登录成功：
{
    &quot;ret&quot; : 0,
    &quot;data&quot; :
    {
          &quot;boxDoorId&quot;: 通道ID,
          &quot;boxId&quot;: 岗亭ID,
          &quot;name&quot;: 通道名称,
          &quot;isCheck&quot;: 是否为监测口,
          &quot;isTempIn&quot;: 是否为临时入口,
          &quot;isTempOut&quot;: 是否为临时出口,
          &quot;cardRights&quot;: 卡类型权限列表,多选,
          &quot;devices&quot;: 通道对应的设备列表,多选,
          &quot;type&quot;: 通道类型(0-大车场,1-小车场),
          &quot;function&quot;: 通道作用(0-入,1-出),
          &quot;mainControlMachine&quot; : 主控制器机号,
          &quot;barrierGateControlMachine&quot; : 道闸控制器机号
          &quot;status&quot;: 通道状态(0-正常使用,1-停止使用)
     },
    &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h3 id="toc_64">添加通道</h3>

<p>地址：<code>POST</code> http://120.76.155.35:8080/box/boxDoor</p>

<p>请求参数：</p>

<pre><code class="language-none">{
    &quot;name&quot;: 名称,
    &quot;function&quot;: 通道作用(0-入,1-出),
    &quot;type&quot;: 通道类型(0-大车场,1-小车场),
    &quot;mainControlMachine&quot; : 主控制器机号,
    &quot;barrierGateControlMachine&quot; : 道闸控制器机号
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : {
        &quot;boxDoorId&quot; : &quot;通道Id&quot;
    },
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_65">修改通道</h3>

<p>地址：<code>PUT</code> http://120.76.155.35:8080/box/boxDoor</p>

<p>请求参数：</p>

<pre><code class="language-none">{
    &quot;boxDoorId&quot;: 通道ID,
    &quot;name&quot;: 名称,
    &quot;function&quot;: 通道作用(0-入,1-出),
    &quot;type&quot;: 通道类型(0-大车场,1-小车场),
    &quot;mainControlMachine&quot; : 主控制器机号,
    &quot;barrierGateControlMachine&quot; : 道闸控制器机号
    &quot;status&quot;: 通道状态(0-正常使用,1-停止使用)
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : &quot;&quot;
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_66">删除通道</h3>

<p>地址：<code>DELETE</code> http://120.76.155.35:8080/box/boxDoor</p>

<p>请求参数：</p>

<pre><code class="language-none">{
      &quot;boxDoorId&quot;: (ID,必填)
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : &quot;&quot;
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<p><a name="device_module"></a></p>

<h2 id="toc_67">设备模块（device）</h2>

<h3 id="toc_68">获取设备信息</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/device</p>

<p>请求参数:
<code>
{
    // 获取对应数据
    &quot;id&quot; : 设备Id
    // 获取列表
    &quot;boxDoorId&quot; : 通道Id
    &quot;page&quot; : 123
    &quot;perPage&quot; : 123
}
</code></p>

<h4 id="toc_69">不带 id 参数时,获取列表</h4>

<p>响应参数：</p>

<pre><code class="language-none">登录成功：
{
    &quot;ret&quot; : 0,
    /* 分页信息仅当含有page参数时提供 */
    &quot;total&quot;: 总共的数量,
    &quot;perPage&quot;: 每页显示的数量,
    &quot;currentPage&quot;: 当前页码,
    &quot;lastPage&quot;: 最后一页页码,
    &quot;nextPageUrl&quot;: 下一页URL(如果不存在则为null),
    &quot;prevPageUrl&quot;: 上一页URL(如果不存在则为null),
    /* 分页信息尾部 */
    &quot;data&quot; :
    [
        {
          &quot;deviceId&quot;: 设备Id,
          &quot;type&quot;: 类型(0-摄像头,1-LED),
          &quot;ip&quot;: IP地址,
          &quot;port&quot;: 端口号,
          &quot;mac&quot;: MAC地址,
          &quot;userName&quot;: 登录用户名,
          &quot;password&quot;: 登录密码,
          &quot;ledWidth&quot;: LED宽度,
          &quot;ledHeight&quot;: LED高度,
          &quot;controlCardNo&quot;: 控制卡号,
          &quot;boxDoorId&quot;: 通道ID,
          &quot;status&quot;: 状态(0-正常,1-停止),
          &quot;created_at&quot;: 创建时间,
          &quot;updated_at&quot;: 更新时间
        },
       {
          &quot;deviceId&quot;: 设备Id,
          &quot;type&quot;: 类型(0-摄像头,1-LED),
          &quot;ip&quot;: IP地址,
          &quot;port&quot;: 端口号,
          &quot;mac&quot;: MAC地址,
          &quot;userName&quot;: 登录用户名,
          &quot;password&quot;: 登录密码,
          &quot;ledWidth&quot;: LED宽度,
          &quot;ledHeight&quot;: LED高度,
          &quot;controlCardNo&quot;: 控制卡号,
          &quot;boxDoorId&quot;: 通道ID,
          &quot;status&quot;: 状态(0-正常,1-停止),
          &quot;created_at&quot;: 创建时间,
          &quot;updated_at&quot;: 更新时间
        },
        ...
    ]
    &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h4 id="toc_70">带 id 参数时，获取对应数据</h4>

<p>响应参数：</p>

<pre><code class="language-none">登录成功：
{
    &quot;ret&quot; : 0,
    &quot;data&quot; :
    {
          &quot;deviceId&quot;: 设备Id,
          &quot;type&quot;: 类型(0-摄像头,1-LED),
          &quot;ip&quot;: IP地址,
          &quot;port&quot;: 端口号,
          &quot;mac&quot;: MAC地址,
          &quot;userName&quot;: 登录用户名,
          &quot;password&quot;: 登录密码,
          &quot;ledWidth&quot;: LED宽度,
          &quot;ledHeight&quot;: LED高度,
          &quot;controlCardNo&quot;: 控制卡号,
          &quot;boxDoorId&quot;: 通道ID,
          &quot;status&quot;: 状态(0-正常,1-停止),
          &quot;created_at&quot;: 创建时间,
          &quot;updated_at&quot;: 更新时间
        },
    &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h3 id="toc_71">添加设备</h3>

<p>地址：<code>POST</code> http://120.76.155.35:8080/device</p>

<p>请求参数：</p>

<pre><code class="language-none">{
      &quot;type&quot;: 类型(0-摄像头,1-LED,必填),
      &quot;ip&quot;: IP地址(必填),
      &quot;port&quot;: 端口号,
      &quot;mac&quot;: MAC地址,
      &quot;userName&quot;: 登录用户名,
      &quot;password&quot;: 登录密码,
      &quot;ledWidth&quot;: LED宽度,
      &quot;ledHeight&quot;: LED高度,
      &quot;controlCardNo&quot;: 控制卡号,
      &quot;boxDoorId&quot;: 通道ID,
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : {
        &quot;deviceId&quot; : &quot;设备id&quot;
    },
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_72">修改设备</h3>

<p>地址：<code>PUT</code> http://120.76.155.35:8080/device</p>

<p>请求参数：</p>

<pre><code class="language-none">{
      &quot;deviceId&quot;: 设备Id,必填,
      &quot;type&quot;: 类型(0-摄像头,1-LED),
      &quot;ip&quot;: IP地址,
      &quot;port&quot;: 端口号,
      &quot;mac&quot;: MAC地址,
      &quot;userName&quot;: 登录用户名,
      &quot;password&quot;: 登录密码,
      &quot;ledWidth&quot;: LED宽度,
      &quot;ledHeight&quot;: LED高度,
      &quot;controlCardNo&quot;: 控制卡号,
      &quot;boxDoorId&quot;: 通道ID,
      &quot;status&quot;: 状态(0-正常,1-停止),
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : &quot;&quot;
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_73">删除设备</h3>

<p>地址：<code>DELETE</code> http://120.76.155.35:8080/device</p>

<p>请求参数：</p>

<pre><code class="language-none">{
      &quot;deviceId&quot;: (ID,必填)
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : &quot;&quot;
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<p><a name="report_module"></a></p>

<h2 id="toc_74">报表模块（report）</h2>

<p><a name="admission_module"></a></p>

<h2 id="toc_75">车辆出入模块(admission)</h2>

<h3 id="toc_76">获取出入场信息</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/admission</p>

<h4 id="toc_77">不带 id 参数时,获取列表</h4>

<p>响应参数：</p>

<pre><code class="language-none">{
    &quot;ret&quot;: 0,
    &quot;data&quot;: [
    {
      &quot;admissionId&quot;: 3,
      &quot;cardId&quot;: &quot;SC粤B76M25&quot;,
      &quot;userName&quot;: &quot;小邓&quot;,
      &quot;cardType&quot;: &quot;月租卡A类&quot;,
      &quot;cardAmount&quot;: &quot;0.00&quot;,
      &quot;cardTimes&quot;: &quot;10&quot;,
      &quot;cardBeginDate&quot;: &quot;2016-07-30 19:15:36&quot;,
      &quot;cardEndDate&quot;: &quot;2016-08-30 19:15:36&quot;,
      &quot;carNum&quot;: &quot;粤B76M25&quot;,
      &quot;carRegNum&quot;: &quot;黑A00005&quot;,
      &quot;carType&quot;: &quot;奔驰&quot;,
      &quot;carColor&quot;: &quot;2&quot;,
      &quot;enterBoxDoorId&quot;: &quot;16&quot;,
      &quot;exitBoxDoorId&quot;: null,
      &quot;enterImagePath&quot;: &quot;http://swiftggapp.b0.upaiyun.com/appicon.png&quot;,
      &quot;exitImagePath&quot;: null,
      &quot;enterTime&quot;: &quot;2016-08-27 11:48:10&quot;,
      &quot;exitTime&quot;: &quot;1970-01-01 08:00:00&quot;,
      &quot;free&quot;: null,
      &quot;charge&quot;: null,
      &quot;status&quot;: &quot;1&quot;,
      &quot;isGuest&quot;: &quot;0&quot;
    },
        ...
    ]
}</code></pre>

<h4 id="toc_78">带 id 参数时,获取单个信息</h4>

<p>响应参数：</p>

<pre><code class="language-none">{
    &quot;ret&quot;: 0,
    &quot;data&quot;: 
    {
      &quot;admissionId&quot;: 3,
      &quot;cardId&quot;: &quot;SC粤B76M25&quot;,
      &quot;userName&quot;: &quot;小邓&quot;,
      &quot;cardType&quot;: &quot;月租卡A类&quot;,
      &quot;cardAmount&quot;: &quot;0.00&quot;,
      &quot;cardTimes&quot;: &quot;10&quot;,
      &quot;cardBeginDate&quot;: &quot;2016-07-30 19:15:36&quot;,
      &quot;cardEndDate&quot;: &quot;2016-08-30 19:15:36&quot;,
      &quot;carNum&quot;: &quot;粤B76M25&quot;,
      &quot;carRegNum&quot;: &quot;黑A00005&quot;,
      &quot;carType&quot;: &quot;奔驰&quot;,
      &quot;carColor&quot;: &quot;2&quot;,
      &quot;enterBoxDoorId&quot;: &quot;16&quot;,
      &quot;exitBoxDoorId&quot;: null,
      &quot;enterImagePath&quot;: &quot;http://swiftggapp.b0.upaiyun.com/appicon.png&quot;,
      &quot;exitImagePath&quot;: null,
      &quot;enterTime&quot;: &quot;2016-08-27 11:48:10&quot;,
      &quot;exitTime&quot;: &quot;1970-01-01 08:00:00&quot;,
      &quot;free&quot;: null,
      &quot;charge&quot;: null,
      &quot;status&quot;: &quot;1&quot;,
      &quot;isGuest&quot;: &quot;0&quot;
    },
    ...
}</code></pre>

<h3 id="toc_79">搜索出入场信息</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/admission/search?carNum=123&amp;userName=123&amp;enterTimeBegin=2016-07-12 19:00:00&amp;enterTimeEnd=2016-07-14 19:00:00&amp;page=123&amp;perPage=123</p>

<p>响应参数：</p>

<pre><code class="language-none">{
    &quot;ret&quot;: 0,
    &quot;data&quot;: [
    {
      &quot;admissionId&quot;: 3,
      &quot;cardId&quot;: &quot;SC粤B76M25&quot;,
      &quot;userName&quot;: &quot;小邓&quot;,
      &quot;cardType&quot;: &quot;月租卡A类&quot;,
      &quot;cardAmount&quot;: &quot;0.00&quot;,
      &quot;cardTimes&quot;: &quot;10&quot;,
      &quot;cardBeginDate&quot;: &quot;2016-07-30 19:15:36&quot;,
      &quot;cardEndDate&quot;: &quot;2016-08-30 19:15:36&quot;,
      &quot;carNum&quot;: &quot;粤B76M25&quot;,
      &quot;carRegNum&quot;: &quot;黑A00005&quot;,
      &quot;carType&quot;: &quot;奔驰&quot;,
      &quot;carColor&quot;: &quot;2&quot;,
      &quot;enterBoxDoorId&quot;: &quot;16&quot;,
      &quot;exitBoxDoorId&quot;: null,
      &quot;enterImagePath&quot;: &quot;http://swiftggapp.b0.upaiyun.com/appicon.png&quot;,
      &quot;exitImagePath&quot;: null,
      &quot;enterTime&quot;: &quot;2016-08-27 11:48:10&quot;,
      &quot;exitTime&quot;: &quot;1970-01-01 08:00:00&quot;,
      &quot;free&quot;: null,
      &quot;charge&quot;: null,
      &quot;status&quot;: &quot;1&quot;,
      &quot;isGuest&quot;: &quot;0&quot;
    },
        ...
    ]
}</code></pre>

<h3 id="toc_80">获取流水信息</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/admission/flow?boxId=123&amp;page=123&amp;perPage=123</p>

<p>响应参数：</p>

<pre><code class="language-none">{
    &quot;ret&quot;: 0,
    &quot;data&quot;: [
    {
      &quot;id&quot;: 流水ID,
      &quot;boxId&quot;: 岗亭ID,
      &quot;carNum&quot;: 车牌号码,
      &quot;cardType&quot;: 卡类型(车类型),
      &quot;enterBoxDoorName&quot;: 入口通道名称,
      &quot;exitBoxDoorName&quot;: 出口通道名称,
      &quot;enterTime&quot;: 进场时间,
      &quot;exitTime&quot;: 出场时间,
      &quot;charge&quot;: 免费的金额,
      &quot;free&quot;: 产生的费用,
      &quot;imagePath&quot;: 图片地址(相对)
    },
        ...
    ]
}</code></pre>

<p><a name="config_module"></a></p>

<h2 id="toc_81">配置模块（config）</h2>

<h3 id="toc_82">获取配置信息</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/configure?name=123&amp;page=123&amp;perPage=123</p>

<h4 id="toc_83">不带 name 参数时,获取列表</h4>

<p>响应参数：</p>

<pre><code class="language-none">{
  &quot;ret&quot;: 0,
  /* 分页信息仅当含有page参数时提供 */
  &quot;total&quot;: 总共的数量,
  &quot;perPage&quot;: 每页显示的数量,
  &quot;currentPage&quot;: 当前页码,
  &quot;lastPage&quot;: 最后一页页码,
  &quot;nextPageUrl&quot;: 下一页URL(如果不存在则为null),
  &quot;prevPageUrl&quot;: 上一页URL(如果不存在则为null),
  /* 分页信息尾部 */
  &quot;data&quot;: [
    {
      /* 剩余大车位 */
      &quot;configureId&quot;: 1,
      &quot;name&quot;: &quot;REST_LARGE_PARK_NUMBER&quot;,
      &quot;value&quot;: 1001,
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-27 23:37:46&quot;
    },
    {
      /* 剩余小车位 */
      &quot;configureId&quot;: 2,
      &quot;name&quot;: &quot;REST_SMAILL_PARK_NUMBER&quot;,
      &quot;value&quot;: 100,
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    },
    {
      /* 是否有小车场 */
      &quot;configureId&quot;: 3,
      &quot;name&quot;: &quot;IS_EXIST_SMALL_PARK&quot;,
      &quot;value&quot;: 1,
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    },
    {
      /* 早上音量开始时间 */
      &quot;configureId&quot;: 4,
      &quot;name&quot;: &quot;VOLUME_DAY_BEGINTIME&quot;,
      &quot;value&quot;: null,
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    },
    {
      /* 早上音量大小 */
      &quot;configureId&quot;: 5,
      &quot;name&quot;: &quot;VOLUME_DAY_LEVEL&quot;,
      &quot;value&quot;: 5,
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    },
    {
      /* 晚上音量开始时间 */
      &quot;configureId&quot;: 6,
      &quot;name&quot;: &quot;VOLUME_NIGHT_BEGINTIME&quot;,
      &quot;value&quot;: null,
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-19 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    },
    {
      /* 晚上音量大小 */
      &quot;configureId&quot;: 7,
      &quot;name&quot;: &quot;VOLUME_NIGHT_LEVEL&quot;,
      &quot;value&quot;: 1,
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-19 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    },
    {
      /* 模态框出现秒数 */
      &quot;configureId&quot;: 8,
      &quot;name&quot;: &quot;MONITOR_DIALOG_TIME&quot;,
      &quot;value&quot;: 5,
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    },
    {
      /* 模态框选项类似 */
      &quot;configureId&quot;: 9,
      &quot;name&quot;: &quot;MONITOR_DIALOG_TYPE&quot;,
      &quot;value&quot;: [
        0,
        1,
        2,
        3,
        4,
        5
      ],
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    },
    {
      /* 是否有水印 */
      &quot;configureId&quot;: 10,
      &quot;name&quot;: &quot;IS_HAS_WATERMARK&quot;,
      &quot;value&quot;: 0,
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    },
    {
      /* 图片保存时间 */
      &quot;configureId&quot;: 11,
      &quot;name&quot;: &quot;PICTURE_SAVE_DAYS&quot;,
      &quot;value&quot;: 30,
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    },
    {
      /* 是否需要道闸反馈 */
      &quot;configureId&quot;: 12,
      &quot;name&quot;: &quot;IS_BARRIER_GATE&quot;,
      &quot;value&quot;: 0,
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    },
    {
      /* 脱机临时车辆进场设置 */
      &quot;configureId&quot;: 13,
      &quot;name&quot;: &quot;OFFLINE_TEMP_CAR_ENTER_SETTING&quot;,
      &quot;value&quot;: 0,
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    },
    {
      /* 脱机临时车辆出场设置 */
      &quot;configureId&quot;: 14,
      &quot;name&quot;: &quot;OFFLINE_TEMP_CAR_EXIT_SETTING&quot;,
      &quot;value&quot;: 1,
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    },
    {
      /* 满位设置 */
      &quot;configureId&quot;: 15,
      &quot;name&quot;: &quot;Full_SETTING_TYPE&quot;,
      &quot;value&quot;: [
        0,
        1,
        2,
        3
      ],
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    },
    {
      /* 常用车牌字头 */
      &quot;configureId&quot;: 16,
      &quot;name&quot;: &quot;COMMON_CAR_LOCATION_NAME&quot;,
      &quot;value&quot;: [
        &quot;京&quot;,
        &quot;粤&quot;,
        &quot;湘&quot;,
        &quot;黑&quot;
      ],
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-27 23:26:05&quot;
    },
    {
      /* 所有车牌字头(默认) */
      &quot;configureId&quot;: 17,
      &quot;name&quot;: &quot;ALL_CAR_LOCATION_NAME&quot;,
      &quot;value&quot;: [
        &quot;京&quot;,
        &quot;津&quot;,
        &quot;沪&quot;,
        &quot;渝&quot;,
        &quot;冀&quot;,
        &quot;豫&quot;,
        &quot;云&quot;,
        &quot;辽&quot;,
        &quot;黑&quot;,
        &quot;湘&quot;,
        &quot;皖&quot;,
        &quot;鲁&quot;,
        &quot;新&quot;,
        &quot;苏&quot;,
        &quot;浙&quot;,
        &quot;赣&quot;,
        &quot;鄂&quot;,
        &quot;桂&quot;,
        &quot;甘&quot;,
        &quot;晋&quot;,
        &quot;粤&quot;
      ],
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    },
    {
      /* 容错位数 */
      &quot;configureId&quot;: 18,
      &quot;name&quot;: &quot;CAR_NUMBER_FAULT_TOLERANCE_BIT&quot;,
      &quot;value&quot;: 0,
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    },
    {
      /* 同通道同车牌识别过滤时间 */
      &quot;configureId&quot;: 19,
      &quot;name&quot;: &quot;SAME_BOX_DOOR_SAME_CAR_NUMBER_FILTER_TIME&quot;,
      &quot;value&quot;: 10,
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    },
    {
      /* 不同通道同车牌识别过滤时间 */
      &quot;configureId&quot;: 20,
      &quot;name&quot;: &quot;DIFFERENt_BOX_DOOR_SAME_CAR_NUMBER_FILTER_TIME&quot;,
      &quot;value&quot;: 20,
      &quot;type&quot;: &quot;0&quot;,
      &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
      &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
    }
  ],
  &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h4 id="toc_84">带 name 参数时，获取对应数据</h4>

<p>响应参数：</p>

<pre><code class="language-none">登录成功：
{
    &quot;ret&quot; : 0,
    &quot;data&quot; :
    {
      /* 不同通道同车牌识别过滤时间 */
      &quot;configureId&quot;: 20,
      &quot;name&quot;: 键,
      &quot;value&quot;: 值,
      &quot;type&quot;: 类型(0-车场配置，1-岗亭配置),
      &quot;created_at&quot;: 创建时间,
      &quot;updated_at&quot;: 更新时间
    },
    &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h3 id="toc_85">修改车场配置</h3>

<p>地址：<code>PUT</code> http://120.76.155.35:8080/configure/park</p>

<p>请求参数：</p>

<pre><code class="language-none">{
   &quot;configureId&quot;: ID,
   &quot;name&quot;: 键,
   &quot;value&quot;: 值,
}</code></pre>

<h3 id="toc_86">修改岗亭配置</h3>

<p>地址：<code>PUT</code> http://120.76.155.35:8080/configure/box</p>

<p>请求参数：</p>

<pre><code class="language-none">{
   &quot;configureId&quot;: ID,
   &quot;name&quot;: 键,
   &quot;boxId&quot;: 岗亭ID,
   &quot;value&quot;: 值,
}</code></pre>

<p><a name="pay_module"></a></p>

<h2 id="toc_87">收费模块（pay）</h2>

<h3 id="toc_88">获取收费配置信息(pay/config)</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/pay/config?id=xx&amp;page=xx&amp;perPage=xxx</p>

<h4 id="toc_89">不带 id 参数时,获取列表</h4>

<p>响应结果：</p>

<pre><code class="language-none">{
    &quot;ret&quot; : 0,
    &quot;data&quot; : 
    {
        {
          &quot;id&quot;: 1,
          &quot;name&quot;: &quot;时租车A类收费&quot;,
          &quot;payRule&quot;: { // 存储每个收费标准具体的配置
          },
          &quot;cardTypeId&quot;: 1,
          &quot;cardType&quot;: &quot;时租卡&quot;,
          &quot;cardSubType&quot;: &quot;A类&quot;,
          &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
          &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
        },
        {
          &quot;id&quot;: 2,
          &quot;name&quot;: &quot;时租车A类收费&quot;,
          &quot;payRule&quot;: { // 存储每个收费标准具体的配置
          },
          &quot;cardTypeId&quot;: 1,
          &quot;cardType&quot;: &quot;时租卡&quot;,
          &quot;cardSubType&quot;: &quot;A类&quot;,
          &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
          &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;
        }

    },
    &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h4 id="toc_90">带有 id 时，获取详情</h4>

<pre><code class="language-none">{
    &quot;ret&quot; : 0,
    &quot;data&quot; : 
    {
          &quot;id&quot;: 2,
          &quot;name&quot;: &quot;时租车A类收费&quot;,
          &quot;payRule&quot;: { // 存储每个收费标准具体的配置
          },
          &quot;cardTypeId&quot;: 1,
          &quot;cardType&quot;: &quot;时租卡&quot;,
          &quot;cardSubType&quot;: &quot;A类&quot;,
          &quot;created_at&quot;: &quot;2016-07-26 16:00:00&quot;,
          &quot;updated_at&quot;: &quot;2016-07-26 16:00:00&quot;    },
    &quot;errMsg&quot;: &quot;&quot;
}</code></pre>

<h3 id="toc_91">添加收费配置</h3>

<p>地址：<code>POST</code> http://120.76.155.35:8080/pay/config</p>

<p>请求参数：</p>

<pre><code class="language-none">{
    &quot;name&quot; : 收费配置名称
    &quot;payRuleId&quot; : 收费规则id
    &quot;cardTypeId&quot; : 123
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : {
        &quot;deviceId&quot; : &quot;设备id&quot;
    },
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_92">修改收费配置</h3>

<p>地址：<code>PUT</code> http://120.76.155.35:8080/pay/config</p>

<p>请求参数：</p>

<pre><code class="language-none">{
  &quot;id&quot;: 2,
  &quot;name&quot;: &quot;时租车A类收费&quot;,
  &quot;payRule&quot;: { // 存储每个收费标准具体的配置
  },
  &quot;cardTypeId&quot;: 1,
  &quot;payRuleId&quot; : 1
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : &quot;&quot;
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_93">删除收费配置</h3>

<p>地址：<code>DELETE</code> http://120.76.155.35:8080/pay/config</p>

<p>请求参数：</p>

<pre><code class="language-none">{
      &quot;configId&quot;: (ID,必填)
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : &quot;&quot;
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_94">计算收费</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/pay/calc</p>

<p>请求参数：</p>

<pre><code class="language-none">{
      &quot;cardId&quot;: 卡片id,
      &quot;beginTime&quot;: 开始时间,
      &quot;endTime&quot;: 结束时间
}</code></pre>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : &quot;&quot;
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<h3 id="toc_95">收费记录</h3>

<p>地址：<code>GET</code> http://120.76.155.35:8080/pay/records</p>

<p>请求参数:
<code>
{
    // 获取对应数据
    &quot;cardId&quot; : 配置Id
    &quot;beginTime&quot;: 开始时间,
    &quot;endTime&quot;: 结束时间 
    // 获取列表
    &quot;page&quot; : 123
    &quot;perPage&quot; : 123
}
</code></p>

<p>返回结果：</p>

<pre><code class="language-none">{
     &quot;ret&quot; : 0,
     &quot;data&quot; : &quot;&quot;
     &quot;errMsg&quot; : &quot;&quot;
}</code></pre>

<p><a name="cloud_module"></a></p>

<h2 id="toc_96">云平台模块（cloud）</h2>

<p><a name="error_and_update_doc"></a></p>

<h2 id="toc_97">错误码和接口更新说明</h2>

<h4 id="toc_98">接口更新说明文档</h4>

<p>具体的接口更新说明请查看<a href="http://120.76.155.35:8080/interfaceHistoryDoc">接口更新说明文档</a></p>

<h4 id="toc_99">错误码文档</h4>

<p>具体的错误码说明请查看<a href="http://120.76.155.35:8080/errorCodeDoc">错误码说明文档</a></p>


</body>

</html>
