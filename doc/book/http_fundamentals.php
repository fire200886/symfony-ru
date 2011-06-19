<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Основы Symfony2 и HTTP</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="symfony2-and-http-fundamentals">
      <span id="index-0"></span><h1>Основы Symfony2 и HTTP<a class="headerlink" href="#symfony2-and-http-fundamentals" title="Permalink to this headline">¶</a></h1>
      <p>Поздравляем! Изучая Symfony2, вы становитесь на правильный (истинный) путь и будете более <em>продуктивным</em>, <em>всесторонним</em> и <em>популярным</em> веб-разработчиком (на самом деле, 2 последних пункта на ваше усмотрение). Symfony2 построен так, чтобы вернуться к основам: разработаны инструменты, которые позволят вам разрабатывать быстрее и создавать более надежные приложения, оставаясь вне вашего пути. Symfony построен на лучших идеях многих технологий: инструменты и концепции, которые вы собираетесь изучать, представляют усилия тысячи людей, в течении многих лет. Другими словами, вы не просто изучаете “Symfony”, вы изучаете основы веб, лучшие практики разработки, и как пользоваться многими новыми, удивительные PHP-библиотеки, внутри или независимо от Symfony2. Итак, приготовьтесь.</p>
      <p>Оставаясь верной философии Symfony2, эта глава начинается с объяснений основных концепций, общих для веб-разработки: HTTP. Независимо от вашего происхождения или языка программирования, эта глава <strong>обязательна к прочтению</strong> для всех.</p>
      <div class="section" id="http-is-simple">
	<h2>HTTP это просто<a class="headerlink" href="#http-is-simple" title="Permalink to this headline">¶</a></h2>
	<p>HTTP (для гиков Hypertext Transfer Protocol) – текстовый язык, позволяющий двум машинам общаться между собой. Вот и все! Например, когда мы проверяем последний <a class="reference external" href="http://xkcd.com/">xkcd</a> комикс, осуществляется следующая (приблизительно) беседа:</p>
	<img alt="../_images/http-xkcd.png" class="align-center" src="../_images/http-xkcd.png">
	<p>И пока фактический язык используется чуть более формально, он остается простым. HTTP – термин, использующийся для описания этого простого текстового языка. И независимо от того, как вы разрабатываете в вебе, цель вашего сервера – понимать простые текстовые запросы, и возвращать простые текстовые ответы.</p>
	<p>Symfony2 построен вокруг этой действительности. Понимаете ли вы это или нет, HTTP, это то, что вы используете каждый день. С Symfony2 вы узнаете как справляться с этим..</p>
	<div class="section" id="step1-the-client-sends-a-request">
	  <span id="index-1"></span><h3>Шаг 1: Клиент посылает запрос<a class="headerlink" href="#step1-the-client-sends-a-request" title="Permalink to this headline">¶</a></h3>
	  <p>Каждое общение в сети начинается с <em>запроса</em>. Запрос – текстовое сообщение, созданное клиентом (например браузер, приложение iPhone и т.д.) в специальном формате, известном как HTTP. Клиент посылает запрос серверу, и затем ожидает ответа.</p>
	  <p>Давайте взглянем на первую часть взаимодействия (запрос) между браузером и веб-сервером xkcd:</p>
	  <img alt="../_images/http-xkcd-request.png" class="align-center" src="../_images/http-xkcd-request.png">
	  <p>В синтаксисе HTTP, этот запрос на самом деле будет выглядеть так:</p>
	  <div class="highlight-text"><div class="highlight"><pre>GET / HTTP/1.1
Host: xkcd.com
Accept: text/html
User-Agent: Mozilla/5.0 (Macintosh)
	    </pre></div>
	  </div>
	  <p>Это простое сообщение содержит данные о том, какой именно ресурс запрашивается клиентом. Первая строка HTTP-запроса очень важна: она содержит две вещи: URI и метод HTTP.</p>
	  <p>URI (например <tt class="docutils literal"><span class="pre">/</span></tt>, <tt class="docutils literal"><span class="pre">/contact</span></tt> и т.д.) это уникальный адрес или место нахождения, идентифицирующее ресурс, который запрашивает клиент. HTTP-метод (например <tt class="docutils literal"><span class="pre">GET</span></tt>)
	     определяет, что вы хотите <em>делать</em> с ресурсом. HTTP-методы являются <em>действиями</em> (глаголы) запроса, и определяют несколько общих способов, которыми вы можете воздействовать на ресурс:</p>
	  <table border="1" class="docutils">
	    <colgroup>
	      <col width="20%">
	      <col width="80%">
	    </colgroup>
	    <tbody valign="top">
	      <tr><td><em>GET</em></td>
		<td>Получить ресурс с сервера</td>
	      </tr>
	      <tr><td><em>POST</em></td>
		<td>Создать ресурс на сервере</td>
	      </tr>
	      <tr><td><em>PUT</em></td>
		<td>Обновить ресурс на сервере</td>
	      </tr>
	      <tr><td><em>DELETE</em></td>
		<td>Удалить ресурс с сервера</td>
	      </tr>
	    </tbody>
	  </table>
	  <p>Имея это в виду, вы можете представить ка будет выглядеть HTTP-запрос для удаления конкретной записи в блоге, например::</p>
	  <div class="highlight-text"><div class="highlight"><pre>DELETE /blog/15 HTTP/1.1
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">Фактически существует девять HTTP-методов, определяемых спецификацией HTTP, но многие из них не используются столь широко или не поддерживаются. В действительности, многие современные браузеры, не поддерживают методы <tt class="docutils literal"><span class="pre">PUT</span></tt> и <tt class="docutils literal"><span class="pre">DELETE</span></tt>.</p>
	  </div></div>
	  <p>В дополнение к первой строке, HTTP-запрос содержит другую информацию, называемой заголовками HTTP-запроса. Заголовки могут предоставлять широкий диапазон информации, такую как, запрашиваемый <tt class="docutils literal"><span class="pre">Host</span></tt>, формат ответа принимаемый клиентом (<tt class="docutils literal"><span class="pre">Accept</span></tt>) и приложение используемое клиентов для выполнения запроса (<tt class="docutils literal"><span class="pre">User-Agent</span></tt>). Существует много других заголовков, которые можно найти в <a class="reference external" href="http://en.wikipedia.org/wiki/List_of_HTTP_header_fields">Википедии</a>.</p>
	</div>
	<div class="section" id="step-2-the-server-returns-a-response">
	  <h3>Шаг 2: Сервер возвращает ответ<a class="headerlink" href="#step-2-the-server-returns-a-response" title="Permalink to this headline">¶</a></h3>
	  <p>Как только сервер получил запрос, он знает, какие именно ресурсы требуются клиенту (посредством URI) и что клиент хочет делать с ресурсом (посредством метода). Например, в случае с запросом GET, сервер подготавливает ресурс и возвращает его в виде HTTP-ответа. Рассмотрим ответ от веб-сервера xkcd:</p>
	  <img alt="../_images/http-xkcd.png" class="align-center" src="../_images/http-xkcd.png">
	  <p>В переводе на HTTP, ответ отправленный обратно в браузер будет выглядеть примерно так:</p>
	  <div class="highlight-text"><div class="highlight"><pre>HTTP/1.1 200 OK
Date: Sat, 02 Apr 2011 21:05:05 GMT
Server: lighttpd/1.4.19
Content-Type: text/html

&lt;html&gt;
  &lt;!-- HTML for the xkcd comic --&gt;
&lt;/html&gt;
	    </pre></div>
	  </div>
	  <p>HTTP-ответ содержит запрошенный ресурс (в данном случае HTML контент), а также другую информацию о запросе. Первая строка особенно важна и содержит код статуса HTTP-ответа (в данном случае 200). Код статуса сообщает общий результат запроса обратно клиенту. Был ли запрос успешен? Были ли ошибки? Существуют другие коды статуса, которые указывают на успех, ошибку или то, что хочет клиент (например редирект на другую страницу). Полный список можно найти в <a class="reference external" href="http://en.wikipedia.org/wiki/List_of_HTTP_status_codes">Википедии</a>.</p>
	  <p>Как и запрос, HTTP-ответ содержит различную информацию, известную как HTTP-заголовки. Например, один из важнейших заголовков HTTP-ответа это
	    <tt class="docutils literal"><span class="pre">Content-Type</span></tt>. Тело того же ресурса, может возвратиться в нескольких разных форматах включающих HTML, XML или JSON. Заголовок <tt class="docutils literal"><span class="pre">Content-Type</span></tt>
	    сообщает клиенту в каком формате возвратился ответ.</p>
	  <p>Существует масса других заголовков, некоторые из которых очень значительны. Например, некоторые заголовки могут быть использованы для создания мощной системы кеширования.</p>
	</div>
	<div class="section" id="requests-responses-and-web-development">
	  <h3>Запросы, ответы и веб-разработка<a class="headerlink" href="#requests-responses-and-web-development" title="Permalink to this headline">¶</a></h3>
	  <p>Общение запрос-ответ – фундаментальный процесс движущий все взаимодействия в сети. И как и все важное и значительное, оно до безобразия просто.</p>
	  <p>Важный факт во всем этом: независимо от того, какой язык вы используете, приложение какого типа вы создаете (веб, мобильное, JSON API) или какую философию разработки исповедуете, конечная цель приложения это <strong>всегда</strong> понимание каждого запроса, создание и возврат соответствующего ответа.</p>
	  <p>Symfony спроектирован так, чтобы соответствовать этой действительности.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">Чтобы узнать больше о спецификации HTTP, прочтите оригинальную <a class="reference external" href="http://www.w3.org/Protocols/rfc2616/rfc2616.html">HTTP 1.1 RFC</a>
		или <a class="reference external" href="http://datatracker.ietf.org/wg/httpbis/">HTTP Bis</a>, статьи, которые отлично разъясняют исходную спецификацию. Великолепным инструментом для проверки заголовков запроса и ответа в браузере, является расширение для Firefox <a class="reference external" href="https://addons.mozilla.org/en-US/firefox/addon/3829/">Live HTTP Headers</a>.</p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="requests-and-responses-in-php">
	<span id="index-2"></span><h2>Запросы и ответы в PHP<a class="headerlink" href="#requests-and-responses-in-php" title="Permalink to this headline">¶</a></h2>
	<p>Итак, как вы можете взаимодействовать с “запросом” и создавать “ответ” используя PHP? В действительности PHP абстрагирует вас от этого процесса:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="o">&lt;?</span><span class="nx">php</span>
<span class="nv">$uri</span> <span class="o">=</span> <span class="nv">$_SERVER</span><span class="p">[</span><span class="s1">'REQUEST_URI'</span><span class="p">];</span>
<span class="nv">$foo</span> <span class="o">=</span> <span class="nv">$_GET</span><span class="p">[</span><span class="s1">'foo'</span><span class="p">];</span>

<span class="nb">header</span><span class="p">(</span><span class="s1">'Content-type: text/html'</span><span class="p">);</span>
<span class="k">echo</span> <span class="s1">'The URI requested is: '</span><span class="o">.</span><span class="nv">$uri</span><span class="p">;</span>
<span class="k">echo</span> <span class="s1">'The value of the "foo" parameter is: '</span><span class="o">.</span><span class="nv">$foo</span><span class="p">;</span>
	  </pre></div>
	</div>
	<p>Как ни странно это звучит, это маленькое приложение фактические берет информацию из HTTP-запроса и использует его для создания HTTP-ответа. Вместо разбора сообщения HTTP-запроса, PHP подготавливает суперглобальные массивы, такие как <tt class="docutils literal"><span class="pre">$_SERVER</span></tt> и <tt class="docutils literal"><span class="pre">$_GET</span></tt>, в которых содержится вся информация запроса. Аналогично, вместо возвращения текстового сообщения в формате HTTP, вы можете использовать функцию <tt class="docutils literal"><span class="pre">header()</span></tt> для создания заголовков ответа и просто вывести контент, который будет содержанием части сообщения ответа. PHP создаст настоящий HTTP-ответ и вернет его клиенту:</p>
	<div class="highlight-text"><div class="highlight"><pre>HTTP/1.1 200 OK
Date: Sat, 03 Apr 2011 02:14:33 GMT
Server: Apache/2.2.17 (Unix)
Content-Type: text/html

The URI requested is: /testing?foo=symfony
The value of the "foo" parameter is: symfony
	  </pre></div>
	</div>
      </div>
      <div class="section" id="requests-and-responses-in-symfony">
	<h2>Запросы и ответы в Symfony<a class="headerlink" href="#requests-and-responses-in-symfony" title="Permalink to this headline">¶</a></h2>
	<p>Symfony предоставляет альтернативу подходу PHP, посредством двух классов, которые позволяют вам взаимодействовать с HTTP-запросом и ответом более простым путем. Класс <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/HttpFoundation/Request.html" title="Symfony\Component\HttpFoundation\Request"><span class="pre">Request</span></a></tt> – простое объектно-ориентированное представление сообщения HTTP-запроса. С ним, в ваших руках имеется вся информация запроса:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Request</span><span class="p">;</span>

<span class="nv">$request</span> <span class="o">=</span> <span class="nx">Request</span><span class="o">::</span><span class="na">createFromGlobals</span><span class="p">();</span>

<span class="c1">// the URI being requested (e.g. /about) minus any query parameters</span>
<span class="nv">$request</span><span class="o">-&gt;</span><span class="na">getPathInfo</span><span class="p">();</span>

<span class="c1">// retrieve GET and POST variables respectively</span>
<span class="nv">$request</span><span class="o">-&gt;</span><span class="na">query</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'foo'</span><span class="p">);</span>
<span class="nv">$request</span><span class="o">-&gt;</span><span class="na">request</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'bar'</span><span class="p">);</span>

<span class="c1">// retrieves an instance of UploadedFile identified by foo</span>
<span class="nv">$request</span><span class="o">-&gt;</span><span class="na">files</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'foo'</span><span class="p">);</span>

<span class="nv">$request</span><span class="o">-&gt;</span><span class="na">getMethod</span><span class="p">();</span>          <span class="c1">// GET, POST, PUT, DELETE, HEAD</span>
<span class="nv">$request</span><span class="o">-&gt;</span><span class="na">getLanguages</span><span class="p">();</span>       <span class="c1">// an array of languages the client accepts</span>
	  </pre></div>
	</div>
	<p>В качестве бонуса, класс <tt class="docutils literal"><span class="pre">Request</span></tt> выполняет множество черновой работы в фоновом режиме, так что вы можете не беспокоиться об этом. Например, метод <tt class="docutils literal"><span class="pre">isSecure()</span></tt> проверяет <em>три</em> различных значения в PHP, которые указывают установил ли пользователь защищенное соединение (т.е. <tt class="docutils literal"><span class="pre">https</span></tt>).</p>
	<p>Symfony также предоставляет класс <tt class="docutils literal"><span class="pre">Response</span></tt>: простое PHP представление сообщения HTTP-ответа. Он позволяет вашему приложению использовать объектно-ориентированный интерфейс для построения ответа, который должен быть возвращен клиенту:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Response</span><span class="p">;</span>
<span class="nv">$response</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">();</span>

<span class="nv">$response</span><span class="o">-&gt;</span><span class="na">setContent</span><span class="p">(</span><span class="s1">'&lt;html&gt;&lt;body&gt;&lt;h1&gt;Hello world!&lt;/h1&gt;&lt;/body&gt;&lt;/html&gt;'</span><span class="p">);</span>
<span class="nv">$response</span><span class="o">-&gt;</span><span class="na">setStatusCode</span><span class="p">(</span><span class="mi">200</span><span class="p">);</span>
<span class="nv">$response</span><span class="o">-&gt;</span><span class="na">headers</span><span class="o">-&gt;</span><span class="na">set</span><span class="p">(</span><span class="s1">'Content-Type'</span><span class="p">,</span> <span class="s1">'text/html'</span><span class="p">);</span>

<span class="c1">// prints the HTTP headers followed by the content</span>
<span class="nv">$response</span><span class="o">-&gt;</span><span class="na">send</span><span class="p">();</span>
	  </pre></div>
	</div>
	<p>Если же Symfony не предлагает ничего другого, то у все все равно уже есть инструментарий для легкого доступа к информации запроса и объектно-ориентированный интерфейс для создания ответа. Даже если вы изучите многие сильные возможности Symfony, имейте ввиду, что цель вашего приложения <em>интерпретировать запрос и создавать соответствующий ответ, основанный на логике вашего приложения</em>.</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Классы <tt class="docutils literal"><span class="pre">Request</span></tt> и <tt class="docutils literal"><span class="pre">Response</span></tt> – часть автономного компонента включенного в Symfony и называемого <tt class="docutils literal"><span class="pre">HttpFoundation</span></tt>. Этот компонент может быть использован полностью независимо от Symfony и также предоставляет классы для обработки сессий и загрузки файлов.</p>
	</div></div>
      </div>
      <div class="section" id="the-journey-from-the-request-to-the-response">
	<h2>Путешествие от запроса к ответу<a class="headerlink" href="#the-journey-from-the-request-to-the-response" title="Permalink to this headline">¶</a></h2>
	<p>Как и HTTP, объекты <tt class="docutils literal"><span class="pre">Request</span></tt> и <tt class="docutils literal"><span class="pre">Response</span></tt> очень просты. Сложная часть построения приложения описывает то, что происходит между ними. Другими словами, реальная работа настает тогда, когда пишется код интерпретирующий информацию запроса и создающий ответ.</p>
	<p>Ваше приложение, вероятно делает много вещей, такие как, отсылка почты, обработка форм, сохранение в базу данных, рендеринг HTML страниц и защита контента. Как вы будете управлять всем этим и по-прежнему держать ваш код организованным и поддерживаемым?</p>
	<p>Symfony создан для решения этих проблем, так что вы не должны иметь их.</p>
	<div class="section" id="the-front-controller">
	  <h3>The Front Controller<a class="headerlink" href="#the-front-controller" title="Permalink to this headline">¶</a></h3>
	  <p>Традиционно, приложения строятся так, что каждой страницей сайта, является его физический файл:</p>
	  <div class="highlight-text"><div class="highlight"><pre>index.php
contact.php
blog.php
	    </pre></div>
	  </div>
	  <p>В этом подходе имеется несколько проблем, в том числе негибкость URL’ов (что, если вы захотите сменить <tt class="docutils literal"><span class="pre">blog.php</span></tt> на <tt class="docutils literal"><span class="pre">news.php</span></tt> без потери всех ваших ссылок?) и тем, что каждый файл <em>должен</em> вручную включить некоторый набор ключевых файлов, так что безопасность, соединение с базой данных, и “взгляд” сайта могут остаться последовательными.</p>
	  <p>Наилучшее решение – это использование <a class="reference internal" href="../glossary.html#term-front-controller"><em class="xref std std-term">front controller</em></a>:  единственного PHP-файла, который обрабатывает каждый запрос, входящий в ваше приложение. Например:</p>
	  <table border="1" class="docutils">
	    <colgroup>
	      <col width="50%">
	      <col width="50%">
	    </colgroup>
	    <tbody valign="top">
	      <tr><td><tt class="docutils literal"><span class="pre">/index.php</span></tt></td>
		<td>запускает <tt class="docutils literal"><span class="pre">index.php</span></tt></td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">/index.php/contact</span></tt></td>
		<td>запускает <tt class="docutils literal"><span class="pre">index.php</span></tt></td>
	      </tr>
	      <tr><td><tt class="docutils literal"><span class="pre">/index.php/blog</span></tt></td>
		<td>запускает <tt class="docutils literal"><span class="pre">index.php</span></tt></td>
	      </tr>
	    </tbody>
	  </table>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">С использованием модуля <tt class="docutils literal"><span class="pre">mod_rewrite</span></tt> веб-сервера Apache (или его эквивалента в других веб-серверах), URL’ы могут быть сокращены до <tt class="docutils literal"><span class="pre">/</span></tt>, <tt class="docutils literal"><span class="pre">/contact</span></tt> и
		<tt class="docutils literal"><span class="pre">/blog</span></tt>.</p>
	  </div></div>
	  <p>Теперь каждый запрос будет обрабатываться одинаково. Вместо отдельных URL’ов, выполняющих отдельные PHP файлы, front controller выполняется всегда, и маршрутизация различных URL’ов производится внутри него. Это решает обе проблемы оригинального подхода. Все современные приложения работают по такому принципу, включая такие приложения, как WordPress.</p>
	</div>
	<div class="section" id="stay-organized">
	  <h3>Оставайтесь организованными<a class="headerlink" href="#stay-organized" title="Permalink to this headline">¶</a></h3>
	  <p>Но как вы узнаете внутри вашего front controller’а, какая страница должна быть отрендерена и выведена? Так или иначе, вы должны проверить входящий URI и выполнить различные части вашего приложения, в зависимости от его значения. Это можно сделать ужасно быстро:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="c1">// index.php</span>

<span class="nv">$request</span> <span class="o">=</span> <span class="nx">Request</span><span class="o">::</span><span class="na">createFromGlobals</span><span class="p">();</span>
<span class="nv">$path</span> <span class="o">=</span> <span class="nv">$request</span><span class="o">-&gt;</span><span class="na">getPathInfo</span><span class="p">();</span> <span class="c1">// the URL being requested</span>

<span class="k">if</span> <span class="p">(</span><span class="nb">in_array</span><span class="p">(</span><span class="nv">$path</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">''</span><span class="p">,</span> <span class="s1">'/'</span><span class="p">))</span> <span class="p">{</span>
    <span class="nv">$response</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="s1">'Welcome to the homepage.'</span><span class="p">);</span>
<span class="p">}</span> <span class="k">elseif</span> <span class="p">(</span><span class="nv">$path</span> <span class="o">==</span> <span class="s1">'/contact'</span><span class="p">)</span> <span class="p">{</span>
    <span class="nv">$response</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="s1">'Contact us'</span><span class="p">);</span>
<span class="p">}</span> <span class="k">else</span> <span class="p">{</span>
    <span class="nv">$response</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="s1">'Page not found.'</span><span class="p">,</span> <span class="mi">404</span><span class="p">);</span>
<span class="p">}</span>
<span class="nv">$response</span><span class="o">-&gt;</span><span class="na">send</span><span class="p">();</span>
	    </pre></div>
	  </div>
	  <p>Решение этой проблемы может быть затруднительным. К счастью, это имено то, для чего создана Symfony.</p>
	</div>
	<div class="section" id="the-symfony-application-flow">
	  <h3>Выполнение приложения Symfony<a class="headerlink" href="#the-symfony-application-flow" title="Permalink to this headline">¶</a></h3>
	  <p>Когда вы позволите Symfony обрабатывать каждый запрос, жизнь облегчится. Symfony для каждого запроса следует одним и тем же шаблонам:</p>
	  <div class="figure align-center" id="request-flow-figure">
	    <img alt="Symfony2 request flow" src="../_images/request-flow.png">
	    <p class="caption">Входящий запрос интерпретируется роутером и передается методам контроллера, возвращающим объекты <tt class="docutils literal"><span class="pre">Response</span></tt>.</p>
	  </div>
	  <p>Каждая страница вашего сайта определяется в файле конфигурации роутинга, который направляет различные URL’ы различными PHP функциям. Работой каждой функции вызываемой <a class="reference internal" href="../glossary.html#term-controller"><em class="xref std std-term">контроллером</em></a>, является использование информации из запроса, наряду с другими инструментами Symfony делающими доступными создание и возвращение объекта <tt class="docutils literal"><span class="pre">Response</span></tt>.
	    Другими словами, контроллер, это то, где проходит <em>ваш</em> код: место, где вы интерпретируете запрос и создаете ответ.</p>
	  <p>Это так просто! Давайте рассмотрим:</p>
	  <ul class="simple">
	    <li>Каждый запрос выполняется в файле front controller’а;</li>
	    <li>Система роутинга определяет, какая PHP функция будет выполнена, основываясь на информации из запроса и конфигурации роутинга, созданного вами;</li>
	    <li>PHP функция будет корректно выполнена тогда, когда ваш код создаст и вернет соответствующий объект <tt class="docutils literal"><span class="pre">Response</span></tt>.</li>
	  </ul>
	</div>
	<div class="section" id="a-symfony-request-in-action">
	  <h3>Symfony Request в действии<a class="headerlink" href="#a-symfony-request-in-action" title="Permalink to this headline">¶</a></h3>
	  <p>Давайте рассмотрим этот процесс в действии без погружения в детали. Пускай вы хотите добавить в ваше Symfony приложение страницу <tt class="docutils literal"><span class="pre">/contact</span></tt>. Сперва начнем с добавления записи в ваш конфигурационный файл роутинга:</p>
	  <div class="highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">contact</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">/contact</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeDemoBundle</span><span class="p-Indicator">:</span><span class="nv">Main</span><span class="p-Indicator">:</span><span class="nv">contact</span> <span class="p-Indicator">}</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">В этом примере, для объявления конфигурации роутинга используется <a class="reference internal" href="../reference/YAML.html"><em>YAML</em></a>. Конфигурация маршрутизации может быть написана в других форматах, таких как XML
		или PHP.</p>
	  </div></div>
	  <p>Когда кто-нибудь посетит страницу  <tt class="docutils literal"><span class="pre">/contact</span></tt> маршрут совпадет и выполнится специфичный контроллер. Как вы узнаете в <a class="reference internal" href="routing.html"><em>главе маршрутизация</em></a>,
	    <tt class="docutils literal"><span class="pre">AcmeDemoBundle:Main:contact</span></tt> это сокращение, указывающее на метод <tt class="docutils literal"><span class="pre">contactAction</span></tt> внутри класса <tt class="docutils literal"><span class="pre">MainController</span></tt>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">class</span> <span class="nc">MainController</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">contactAction</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="k">return</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="s1">'&lt;h1&gt;Contact us!&lt;/h1&gt;'</span><span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>В этом очень простом примере, контроллер просто создает объект <tt class="docutils literal"><span class="pre">Response</span></tt>
	    с HTML содержимым "&lt;h1&gt;Contact us!&lt;/h1&gt;". В <a class="reference internal" href="controller.html"><em>главе контроллер</em></a>
	    вы узнаете, как контроллер может вывести шаблон, позволяющий вашему “презентационному” коду (т.е. всему, что может быть в HTML) находиться в отдельных файлах шаблона. Это позволяет заботиться только о сложным вещах: взаимодействию с базой данных, обработкой поступивших данных или отправкой email сообщений.</p>
	</div>
      </div>
      <div class="section" id="symfony2-build-your-app-not-your-tools">
	<h2>Symfony2: стройте ваши приложения, а не инструменты<a class="headerlink" href="#symfony2-build-your-app-not-your-tools" title="Permalink to this headline">¶</a></h2>
	<p>Теперь вы знаете, что цель любого приложения интерпретация каждого входящего запроса и создание соответствующего ответа. По мере роста приложения, становится все труднее держать ваш код организованным и поддерживаемым. Неизменно остаются вещи повторяющиеся снова и снова: сохранение информации в базу данных, вывод и повторное использование шаблонов, обработка отправок формы, отправка почты, валидация данных пользователя и безопасность.</p>
	<p>Хорошая новость, в том, что ни одна их этих проблем не является уникальной. Symfony предоставляет фреймворк, полный инструментов, которые позволят вам строить приложения, а не инструменты. С Symfony2 ничего вас не связывает: вы свободно можете использовать как весь фреймворк, так и только некоторую часть.</p>
	<div class="section" id="standalone-tools-the-symfony2-components">
	  <span id="index-3"></span><h3>Автономные инструменты: <em>Компоненты</em> Symfony2<a class="headerlink" href="#standalone-tools-the-symfony2-components" title="Permalink to this headline">¶</a></h3>
	  <p>Итак, что такое Symfony? Во первых, Symfony2 коллекция свыше двадцати независимых библиотек, которые могут быть использованы внутри любого PHP проекта. Эти библиотеки, называющиеся компонентами Symfony2, содержат что-то полезное практически для любой ситуации, независимо от того, как разработан ваш проект. Перечислим некоторые:</p>
	  <ul class="simple">
	    <li><a class="reference external" href="https://github.com/symfony/HttpFoundation">HttpFoundation</a> - содержит классы <tt class="docutils literal"><span class="pre">Request</span></tt> и <tt class="docutils literal"><span class="pre">Response</span></tt>, также как и другие классы для обработки сессий и загрузки файлов;</li>
	    <li><a class="reference external" href="https://github.com/symfony/Routing">Routing</a> - мощная и быстрая система маршрутизации, позволяющая вам указывать специфичный URI (например <tt class="docutils literal"><span class="pre">/contact</span></tt>) некоторой информации о том, как будет обработан запрос (например выполнить метод <tt class="docutils literal"><span class="pre">contactAction()</span></tt>);</li>
	    <li><a class="reference external" href="https://github.com/symfony/Form">Form</a> - полнофункциональный и гибкий фреймворк для создания и обработки форм;</li>
	    <li><a class="reference external" href="https://github.com/symfony/Validation">Validation</a> система создания правил для данных, а затем проверки представленных пользователем данных на следование этим правилам;</li>
	    <li><a class="reference external" href="https://github.com/symfony/ClassLoader">ClassLoader</a>  библиотека автозагрузки, позволяющая вызывать классы без непосредственного вызова <tt class="docutils literal"><span class="pre">require</span></tt>;</li>
	    <li><a class="reference external" href="https://github.com/symfony/Templating">Templating</a> инструмент для рендеринга шаблонов, поддерживает наследование шаблонов (т.е. шаблоны оборачиваются в лайауты) и выполняет другие общие задачи;</li>
	    <li><a class="reference external" href="https://github.com/symfony/Security">Security</a> - мощная библиотека для поддержки всех видов безопасности внутри приложения;</li>
	    <li><a class="reference external" href="https://github.com/symfony/Translation">Translation</a> фреймворк, для перевода текста в вашем приложении.</li>
	  </ul>
	  <p>Каждый из этих компонентов независим, и может использоваться в <em>любом</em> PHP проекте, независимо от того используется Symfony2 или нет. Каждая часть сделана так, чтобы при необходимости можно было заменить ее.</p>
	</div>
	<div class="section" id="the-full-solution-the-symfony2-framework">
	  <h3>Полное решение: <em>Фреймворк</em> Symfony2<a class="headerlink" href="#the-full-solution-the-symfony2-framework" title="Permalink to this headline">¶</a></h3>
	  <p>Итак, что же такое фреймворк Symfony2? Фреймворк Symfony2 это PHP библиотека, выполняющая две основные задачи:</p>
	  <ol class="arabic simple">
	    <li>Предоставление выбора компонентов (т.е. компонентов Symfony2) и сторонних библиотек (например <tt class="docutils literal"><span class="pre">Swiftmailer</span></tt> для отравки почты);</li>
	    <li>Предоставление удобной конфигурации и “клея”, связывающего библиотеки друг с другом.</li>
	  </ol>
	  <p>Цель фреймворка, интеграция независимых инструментов, для обеспечения целостности для разработчиков. Даже в самом фреймворке можно настраивать или заменять бандлы (т.е. плагины).</p>
	  <p>Symfony2 предоставляет мощный набор инструментов для быстрой разработки веб-приложений без наложения ограничений. Обычные пользователи могут быстро начать разработку с помощью Symfony2, предоставляющей каркас проекта по-умолчанию. Для более продвинутых пользователей, пределом могут стать только небеса.</p>
	</div>
      </div>
    </div>
  </div>

  <div class="navigation">
    <a accesskey="P" title="Book" href="index.html">
      «&nbsp;Книга
    </a><span class="separator">|</span>
    <a accesskey="N" title="When Flat PHP meets Symfony" href="from_flat_php_to_symfony2.html">
      От плоского PHP кода до Symfony2&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
