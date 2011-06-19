<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Translations</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="translations">
      <span id="index-0"></span><h1>Translations<a class="headerlink" href="#translations" title="Permalink to this headline">¶</a></h1>
      <p>The term "internationalization" refers to the process of abstracting strings
	and other locale-specific pieces out of your application and into a layer
	where they can be translated and converted based on the user's locale (i.e.
	language and country). For text, this means wrapping each with a function
	capable of translating the text (or "message") into the language of the user:</p>
      <div class="highlight-php"><div class="highlight"><pre><span class="c1">// text will *always* print out in English</span>
<span class="k">echo</span> <span class="s1">'Hello World'</span><span class="p">;</span>

<span class="c1">// text can be translated into the end-user's language or default to English</span>
<span class="k">echo</span> <span class="nv">$translator</span><span class="o">-&gt;</span><span class="na">trans</span><span class="p">(</span><span class="s1">'Hello World'</span><span class="p">);</span>
	</pre></div>
      </div>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">The term <em>locale</em> refers roughly to the user's language and country. It
	    can be any string that your application then uses to manage translations
	    and other format differences (e.g. currency format). We recommended the
	    ISO639-1 <em>language</em> code, an underscore (<tt class="docutils literal"><span class="pre">_</span></tt>), then the ISO3166 <em>country</em>
	    code (e.g. <tt class="docutils literal"><span class="pre">fr_FR</span></tt> for French/France).</p>
      </div></div>
      <p>In this chapter, we'll learn how to prepare an application to support multiple
	locales and then how to create translations for multiple locales. Overall,
	the process has several common steps:</p>
      <ol class="arabic simple">
	<li>Enable and configure Symfony's <tt class="docutils literal"><span class="pre">Translation</span></tt> component;</li>
      </ol>
      <ol class="arabic simple">
	<li>Abstract strings (i.e. "messages") by wrapping them in calls to the <tt class="docutils literal"><span class="pre">Translator</span></tt>;</li>
      </ol>
      <ol class="arabic simple">
	<li>Create translation resources for each supported locale that translate
	  each message in the application;</li>
      </ol>
      <ol class="arabic simple">
	<li>Determine, set and manage the user's locale in the session.</li>
      </ol>
      <div class="section" id="configuration">
	<span id="index-1"></span><h2>Configuration<a class="headerlink" href="#configuration" title="Permalink to this headline">¶</a></h2>
	<p>Translations are handled by a <tt class="docutils literal"><span class="pre">Translator</span></tt> <a class="reference internal" href="../glossary.html#term-service"><em class="xref std std-term">service</em></a> that uses the
	  user's locale to lookup and return translated messages. Before using it,
	  enable the <tt class="docutils literal"><span class="pre">Translator</span></tt> in your configuration:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 112px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">framework</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">translator</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">fallback</span><span class="p-Indicator">:</span> <span class="nv">en</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;framework:config&gt;</span>
    <span class="nt">&lt;framework:translator</span> <span class="na">fallback=</span><span class="s">"en"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/framework:config&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'translator'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'fallback'</span> <span class="o">=&gt;</span> <span class="s1">'en'</span><span class="p">),</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>The <tt class="docutils literal"><span class="pre">fallback</span></tt> option defines the fallback locale when a translation does
	  not exist in the user's locale.</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">When a translation does not exist for a locale, the translator first tries
	      to find the translation for the language (<tt class="docutils literal"><span class="pre">fr</span></tt> if the locale is
	      <tt class="docutils literal"><span class="pre">fr_FR</span></tt> for instance). If this also fails, it looks for a translation
	      using the fallback locale.</p>
	</div></div>
	<p>The locale used in translations is the one stored in the user session.</p>
      </div>
      <div class="section" id="basic-translation">
	<span id="index-2"></span><h2>Basic Translation<a class="headerlink" href="#basic-translation" title="Permalink to this headline">¶</a></h2>
	<p>Translation of text is done through the  <tt class="docutils literal"><span class="pre">translator</span></tt> service
	  (<tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Translation/Translator.html" title="Symfony\Component\Translation\Translator"><span class="pre">Translator</span></a></tt>). To translate a block
	  of text (called a <em>message</em>), use the
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Translation/Translator.html#trans()" title="Symfony\Component\Translation\Translator::trans()"><span class="pre">trans()</span></a></tt> method. Suppose,
	  for example, that we're translating a simple message from inside a controller:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$t</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'translator'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">trans</span><span class="p">(</span><span class="s1">'Symfony2 is great'</span><span class="p">);</span>

    <span class="k">return</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="nv">$t</span><span class="p">);</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>When this code is executed, Symfony2 will attempt to translate the message
	  "Symfony2 is great" based on the <tt class="docutils literal"><span class="pre">locale</span></tt> of the user. For this to work,
	  we need to tell Symfony2 how to translate the message via a "translation
	  resource", which is a collection of message translations for a given locale.
	  This "dictionary" of translations can be created in several different formats,
	  XLIFF being the recommended format:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 274px; ">
	    <li class="selected"><em><a href="#">XML</a></em><div class="highlight-xml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">&lt;!-- messages.fr.xliff --&gt;</span>
<span class="cp">&lt;?xml version="1.0"?&gt;</span>
<span class="nt">&lt;xliff</span> <span class="na">version=</span><span class="s">"1.2"</span> <span class="na">xmlns=</span><span class="s">"urn:oasis:names:tc:xliff:document:1.2"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;file</span> <span class="na">source-language=</span><span class="s">"en"</span> <span class="na">datatype=</span><span class="s">"plaintext"</span> <span class="na">original=</span><span class="s">"file.ext"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;body&gt;</span>
            <span class="nt">&lt;trans-unit</span> <span class="na">id=</span><span class="s">"1"</span><span class="nt">&gt;</span>
                <span class="nt">&lt;source&gt;</span>Symfony2 is great<span class="nt">&lt;/source&gt;</span>
                <span class="nt">&lt;target&gt;</span>J'aime Symfony2<span class="nt">&lt;/target&gt;</span>
            <span class="nt">&lt;/trans-unit&gt;</span>
        <span class="nt">&lt;/body&gt;</span>
    <span class="nt">&lt;/file&gt;</span>
<span class="nt">&lt;/xliff&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// messages.fr.php</span>
<span class="k">return</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'Symfony2 is great'</span> <span class="o">=&gt;</span> <span class="s1">'J\'aime Symfony2'</span><span class="p">,</span>
<span class="p">);</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">YAML</a></em><div class="highlight-yaml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1"># messages.fr.yml</span>
<span class="l-Scalar-Plain">Symfony2 is great</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">J'aime Symfony2</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>Now, if the language of the user's locale is French (e.g. <tt class="docutils literal"><span class="pre">fr_FR</span></tt> or <tt class="docutils literal"><span class="pre">fr_BE</span></tt>),
	  the message will be translated into <tt class="docutils literal"><span class="pre">J'aime</span> <span class="pre">Symfony2</span></tt>.</p>
	<div class="section" id="the-translation-process">
	  <h3>The Translation Process<a class="headerlink" href="#the-translation-process" title="Permalink to this headline">¶</a></h3>
	  <p>To actually translate the message, Symfony2 uses a simple process:</p>
	  <ul class="simple">
	    <li>The <tt class="docutils literal"><span class="pre">locale</span></tt> of the current user, which is stored in the session, is determined;</li>
	    <li>A catalog of translated messages is loaded from translation resources defined
	      for the <tt class="docutils literal"><span class="pre">locale</span></tt> (e.g. <tt class="docutils literal"><span class="pre">fr_FR</span></tt>). Messages from the fallback locale are
	      also loaded and added to the catalog if they don't already exist. The end
	      result is a large "dictionary" of translations. See <a class="reference internal" href="#message-catalogues">Message Catalogues</a>
	      for more details;</li>
	    <li>If the message is located in the catalog, the translation is returned. If
	      not, the translator returns the original message.</li>
	  </ul>
	  <p>When using the <tt class="docutils literal"><span class="pre">trans()</span></tt> method, Symfony2 looks for the exact string inside
	    the appropriate message catalog and returns it (if it exists).</p>
	</div>
	<div class="section" id="message-placeholders">
	  <span id="index-3"></span><h3>Message Placeholders<a class="headerlink" href="#message-placeholders" title="Permalink to this headline">¶</a></h3>
	  <p>Sometimes, a message containing a variable needs to be translated:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$t</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'translator'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">trans</span><span class="p">(</span><span class="s1">'Hello '</span><span class="o">.</span><span class="nv">$name</span><span class="p">);</span>

    <span class="k">return</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="nv">$t</span><span class="p">);</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>However, creating a translation for this string is impossible since the translator
	    will try to look up the exact message, including the variable portions
	    (e.g. "Hello Ryan" or "Hello Fabien"). Instead of writing a translation
	    for every possible iteration of the <tt class="docutils literal"><span class="pre">$name</span></tt> variable, we can replace the
	    variable with a "placeholder":</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$t</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'translator'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">trans</span><span class="p">(</span><span class="s1">'Hello %name%'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'%name%'</span> <span class="o">=&gt;</span> <span class="nv">$name</span><span class="p">));</span>

    <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="nv">$t</span><span class="p">);</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Symfony2 will now look for a translation of the raw message (<tt class="docutils literal"><span class="pre">Hello</span> <span class="pre">%name%</span></tt>)
	    and <em>then</em> replace the placeholders with their values. Creating a translation
	    is done just as before:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 274px; ">
	      <li class="selected"><em><a href="#">XML</a></em><div class="highlight-xml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">&lt;!-- messages.fr.xliff --&gt;</span>
<span class="cp">&lt;?xml version="1.0"?&gt;</span>
<span class="nt">&lt;xliff</span> <span class="na">version=</span><span class="s">"1.2"</span> <span class="na">xmlns=</span><span class="s">"urn:oasis:names:tc:xliff:document:1.2"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;file</span> <span class="na">source-language=</span><span class="s">"en"</span> <span class="na">datatype=</span><span class="s">"plaintext"</span> <span class="na">original=</span><span class="s">"file.ext"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;body&gt;</span>
            <span class="nt">&lt;trans-unit</span> <span class="na">id=</span><span class="s">"1"</span><span class="nt">&gt;</span>
                <span class="nt">&lt;source&gt;</span>Hello %name%<span class="nt">&lt;/source&gt;</span>
                <span class="nt">&lt;target&gt;</span>Bonjour %name%<span class="nt">&lt;/target&gt;</span>
            <span class="nt">&lt;/trans-unit&gt;</span>
        <span class="nt">&lt;/body&gt;</span>
    <span class="nt">&lt;/file&gt;</span>
<span class="nt">&lt;/xliff&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// messages.fr.php</span>
<span class="k">return</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'Hello %name%'</span> <span class="o">=&gt;</span> <span class="s1">'Bonjour %name%'</span><span class="p">,</span>
<span class="p">);</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">YAML</a></em><div class="highlight-yaml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1"># messages.fr.yml</span>
<span class="s">'Hello</span><span class="nv"> </span><span class="s">%name%'</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Hello %name%</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">The placeholders can take on any form as the full message is reconstructed
		using the PHP <a class="reference external" href="http://www.php.net/manual/en/function.strtr.php">strtr function</a>. However, the <tt class="docutils literal"><span class="pre">%var%</span></tt> notation is
		required when translating in Twig templates, and is overall a sensible
		convention to follow.</p>
	  </div></div>
	  <p>As we've seen, creating a translation is a two-step process:</p>
	  <ol class="arabic simple">
	    <li>Abstract the message that needs to be translated by processing it through
	      the <tt class="docutils literal"><span class="pre">Translator</span></tt>.</li>
	  </ol>
	  <ol class="arabic simple">
	    <li>Create a translation for the message in each locale that you choose to
	      support.</li>
	  </ol>
	  <p>The second step is done by creating message catalogues that define the translations
	    for any number of different locales.</p>
	</div>
      </div>
      <div class="section" id="message-catalogues">
	<span id="index-4"></span><h2>Message Catalogues<a class="headerlink" href="#message-catalogues" title="Permalink to this headline">¶</a></h2>
	<p>When a message is translated, Symfony2 compiles a message catalogue for the
	  user's locale and looks in it for a translation of the message. A message
	  catalogue is like a dictionary of translations for a specific locale. For
	  example, the catalogue for the <tt class="docutils literal"><span class="pre">fr_FR</span></tt> locale might contain the following
	  translation:</p>
	<blockquote>
	  <div>Symfony2 is Great =&gt; J'aime Symfony2</div></blockquote>
	<p>It's the responsibility of the developer (or translator) of an internationalized
	  application to create these translations. Translations are stored on the
	  filesystem and discovered by Symfony, thanks to some conventions.</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p>Each time you create a <em>new</em> translation resource (or install a bundle
	      that includes a translation resource), be sure to clear your cache so
	      that Symfony can discover the new translation resource:</p>
	    <div class="last highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console cache:clear
	      </pre></div>
	    </div>
	</div></div>
	<div class="section" id="translation-locations-and-naming-conventions">
	  <span id="index-5"></span><h3>Translation Locations and Naming Conventions<a class="headerlink" href="#translation-locations-and-naming-conventions" title="Permalink to this headline">¶</a></h3>
	  <p>Symfony2 looks for message files (i.e. translations) in two locations:</p>
	  <ul class="simple">
	    <li>For messages found in a bundle, the corresponding message files should
	      live in the <tt class="docutils literal"><span class="pre">Resources/translations/</span></tt> directory of the bundle;</li>
	    <li>To override any bundle translations, place message files in the
	      <tt class="docutils literal"><span class="pre">app/Resources/translations</span></tt> directory.</li>
	  </ul>
	  <p>The filename of the translations is also important as Symfony2 uses a convention
	    to determine details about the translations. Each message file must be named
	    according to the following pattern: <tt class="docutils literal"><span class="pre">domain.locale.loader</span></tt>:</p>
	  <ul class="simple">
	    <li><strong>domain</strong>: An optional way to organize messages into groups (e.g. <tt class="docutils literal"><span class="pre">admin</span></tt>,
	      <tt class="docutils literal"><span class="pre">navigation</span></tt> or the default <tt class="docutils literal"><span class="pre">messages</span></tt>) - see <a class="reference internal" href="#using-message-domains">Using Message Domains</a>;</li>
	    <li><strong>locale</strong>: The locale that the translations are for (e.g. <tt class="docutils literal"><span class="pre">en_GB</span></tt>, <tt class="docutils literal"><span class="pre">en</span></tt>, etc);</li>
	    <li><strong>loader</strong>: How Symfony2 should load and parse the file (e.g. <tt class="docutils literal"><span class="pre">xliff</span></tt>,
	      <tt class="docutils literal"><span class="pre">php</span></tt> or <tt class="docutils literal"><span class="pre">yml</span></tt>).</li>
	  </ul>
	  <p>The loader can be the name of any registered loader. By default, Symfony
	    provides the following loaders:</p>
	  <ul class="simple">
	    <li><tt class="docutils literal"><span class="pre">xliff</span></tt>: XLIFF file;</li>
	    <li><tt class="docutils literal"><span class="pre">php</span></tt>:   PHP file;</li>
	    <li><tt class="docutils literal"><span class="pre">yml</span></tt>:  YAML file.</li>
	  </ul>
	  <p>The choice of which loader to use is entirely up to you and is a matter of
	    taste.</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">You can also store translations in a database, or any other storage by
		providing a custom class implementing the
		<tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Translation/Loader/LoaderInterface.html" title="Symfony\Component\Translation\Loader\LoaderInterface"><span class="pre">LoaderInterface</span></a></tt> interface.
		See <tt class="xref doc docutils literal"><span class="pre">Custom</span> <span class="pre">Translation</span> <span class="pre">Loaders</span></tt>
		below to learn how to register custom loaders.</p>
	  </div></div>
	</div>
	<div class="section" id="creating-translations">
	  <span id="index-6"></span><h3>Creating Translations<a class="headerlink" href="#creating-translations" title="Permalink to this headline">¶</a></h3>
	  <p>Each file consists of a series of id-translation pairs for the given domain and
	    locale. The id is the identifier for the individual translation, and can
	    be the message in the main locale (e.g. "Symfony is great") of your application
	    or a unique identifier (e.g. "symfony2.great" - see the sidebar below):</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 346px; ">
	      <li class="selected"><em><a href="#">XML</a></em><div class="highlight-xml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/DemoBundle/Resources/translations/messages.fr.xliff --&gt;</span>
<span class="cp">&lt;?xml version="1.0"?&gt;</span>
<span class="nt">&lt;xliff</span> <span class="na">version=</span><span class="s">"1.2"</span> <span class="na">xmlns=</span><span class="s">"urn:oasis:names:tc:xliff:document:1.2"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;file</span> <span class="na">source-language=</span><span class="s">"en"</span> <span class="na">datatype=</span><span class="s">"plaintext"</span> <span class="na">original=</span><span class="s">"file.ext"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;body&gt;</span>
            <span class="nt">&lt;trans-unit</span> <span class="na">id=</span><span class="s">"1"</span><span class="nt">&gt;</span>
                <span class="nt">&lt;source&gt;</span>Symfony2 is great<span class="nt">&lt;/source&gt;</span>
                <span class="nt">&lt;target&gt;</span>J'aime Symfony2<span class="nt">&lt;/target&gt;</span>
            <span class="nt">&lt;/trans-unit&gt;</span>
            <span class="nt">&lt;trans-unit</span> <span class="na">id=</span><span class="s">"2"</span><span class="nt">&gt;</span>
                <span class="nt">&lt;source&gt;</span>symfony2.great<span class="nt">&lt;/source&gt;</span>
                <span class="nt">&lt;target&gt;</span>J'aime Symfony2<span class="nt">&lt;/target&gt;</span>
            <span class="nt">&lt;/trans-unit&gt;</span>
        <span class="nt">&lt;/body&gt;</span>
    <span class="nt">&lt;/file&gt;</span>
<span class="nt">&lt;/xliff&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/DemoBundle/Resources/translations/messages.fr.php</span>
<span class="k">return</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'Symfony2 is great'</span> <span class="o">=&gt;</span> <span class="s1">'J\'aime Symfony2'</span><span class="p">,</span>
    <span class="s1">'symfony2.great'</span>    <span class="o">=&gt;</span> <span class="s1">'J\'aime Symfony2'</span><span class="p">,</span>
<span class="p">);</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">YAML</a></em><div class="highlight-yaml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1"># src/Acme/DemoBundle/Resources/translations/messages.fr.yml</span>
<span class="l-Scalar-Plain">Symfony2 is great</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">J'aime Symfony2</span>
<span class="l-Scalar-Plain">symfony2.great</span><span class="p-Indicator">:</span>    <span class="l-Scalar-Plain">J'aime Symfony2</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Symfony2 will discover these files and use them when translating either
	    "Symfony2 is great" or "symfony2.great" into a French language locale (e.g.
	    <tt class="docutils literal"><span class="pre">fr_FR</span></tt> or <tt class="docutils literal"><span class="pre">fr_BE</span></tt>).</p>
	  <div class="admonition-wrapper">
	    <div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title">Using Real or Keyword Messages</p>
	      <p>This example illustrates the two different philosophies when creating
		messages to be translated:</p>
	      <div class="highlight-php"><div class="highlight"><pre><span class="nv">$t</span> <span class="o">=</span> <span class="nv">$translator</span><span class="o">-&gt;</span><span class="na">trans</span><span class="p">(</span><span class="s1">'Symfony2 is great'</span><span class="p">);</span>

<span class="nv">$t</span> <span class="o">=</span> <span class="nv">$translator</span><span class="o">-&gt;</span><span class="na">trans</span><span class="p">(</span><span class="s1">'symfony2.great'</span><span class="p">);</span>
		</pre></div>
	      </div>
	      <p>In the first method, messages are written in the language of the default
		locale (English in this case). That message is then used as the "id"
		when creating translations.</p>
	      <p>In the second method, messages are actually "keywords" that convey the
		idea of the message. The keyword message is then used as the "id" for
		any translations. In this case, translations must be made for the default
		locale (i.e. to translate <tt class="docutils literal"><span class="pre">symfony2.great</span></tt> to <tt class="docutils literal"><span class="pre">Symfony2</span> <span class="pre">is</span> <span class="pre">great</span></tt>).</p>
	      <p>The second method is handy because the message key won't need to be changed
		in every translation file if we decide that the message should actually
		read "Symfony2 is really great" in the default locale.</p>
	      <p>The choice of which method to use is entirely up to you, but the "keyword"
		format is often recommended.</p>
	      <p>Additionally, the <tt class="docutils literal"><span class="pre">php</span></tt> and <tt class="docutils literal"><span class="pre">yaml</span></tt> file formats support nested ids to
		avoid repeating yourself if you use keywords instead of real text for your
		ids:</p>
	      <div class="configuration-block jsactive clearfix">
		<ul class="simple" style="height: 202px; ">
		  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">symfony2</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">is</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">great</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Symfony2 is great</span>
        <span class="l-Scalar-Plain">amazing</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Symfony2 is amazing</span>
    <span class="l-Scalar-Plain">has</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">bundles</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Symfony2 has bundles</span>
<span class="l-Scalar-Plain">user</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">login</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Login</span>
		      </pre></div>
		    </div>
		  </li>
		  <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="k">return</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'symfony2'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'is'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'great'</span> <span class="o">=&gt;</span> <span class="s1">'Symfony2 is great'</span><span class="p">,</span>
            <span class="s1">'amazing'</span> <span class="o">=&gt;</span> <span class="s1">'Symfony2 is amazing'</span><span class="p">,</span>
        <span class="p">),</span>
        <span class="s1">'has'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'bundles'</span> <span class="o">=&gt;</span> <span class="s1">'Symfony2 has bundles'</span><span class="p">,</span>
        <span class="p">),</span>
    <span class="p">),</span>
    <span class="s1">'user'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'login'</span> <span class="o">=&gt;</span> <span class="s1">'Login'</span><span class="p">,</span>
    <span class="p">),</span>
<span class="p">);</span>
		      </pre></div>
		    </div>
		  </li>
		</ul>
	      </div>
	      <p>The multiple levels are flattened into single id/translation pairs by
		adding a dot (.) between every level, therefore the above examples are
		equivalent to the following:</p>
	      <div class="last configuration-block jsactive clearfix">
		<ul class="simple" style="height: 130px; ">
		  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">symfony2.is.great</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Symfony2 is great</span>
<span class="l-Scalar-Plain">symfony2.is.amazing</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Symfony2 is amazing</span>
<span class="l-Scalar-Plain">symfony2.has.bundles</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Symfony2 has bundles</span>
<span class="l-Scalar-Plain">user.login</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">Login</span>
		      </pre></div>
		    </div>
		  </li>
		  <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="k">return</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'symfony2.is.great'</span> <span class="o">=&gt;</span> <span class="s1">'Symfony2 is great'</span><span class="p">,</span>
    <span class="s1">'symfony2.is.amazing'</span> <span class="o">=&gt;</span> <span class="s1">'Symfony2 is amazing'</span><span class="p">,</span>
    <span class="s1">'symfony2.has.bundles'</span> <span class="o">=&gt;</span> <span class="s1">'Symfony2 has bundles'</span><span class="p">,</span>
    <span class="s1">'user.login'</span> <span class="o">=&gt;</span> <span class="s1">'Login'</span><span class="p">,</span>
<span class="p">);</span>
		      </pre></div>
		    </div>
		  </li>
		</ul>
	      </div>
	  </div></div>
	</div>
      </div>
      <div class="section" id="using-message-domains">
	<span id="index-7"></span><h2>Using Message Domains<a class="headerlink" href="#using-message-domains" title="Permalink to this headline">¶</a></h2>
	<p>As we've seen, message files are organized into the different locales that
	  they translate. The message files can also be organized further into "domains".
	  When creating message files, the domain is the first portion of the filename.
	  The default domain is <tt class="docutils literal"><span class="pre">messages</span></tt>. For example, suppose that, for organization,
	  translations were split into three different domains: <tt class="docutils literal"><span class="pre">messages</span></tt>, <tt class="docutils literal"><span class="pre">admin</span></tt>
	  and <tt class="docutils literal"><span class="pre">navigation</span></tt>. The French translation would have the following message
	  files:</p>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">messages.fr.xliff</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">admin.fr.xliff</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">navigation.fr.xliff</span></tt></li>
	</ul>
	<p>When translating strings that are not in the default domain (<tt class="docutils literal"><span class="pre">messages</span></tt>),
	  you must specify the domain as the third argument of <tt class="docutils literal"><span class="pre">trans()</span></tt>:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'translator'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">trans</span><span class="p">(</span><span class="s1">'Symfony2 is great'</span><span class="p">,</span> <span class="k">array</span><span class="p">(),</span> <span class="s1">'admin'</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>Symfony2 will now look for the message in the <tt class="docutils literal"><span class="pre">admin</span></tt> domain of the user's
	  locale.</p>
      </div>
      <div class="section" id="handling-the-user-s-locale">
	<span id="index-8"></span><h2>Handling the User's Locale<a class="headerlink" href="#handling-the-user-s-locale" title="Permalink to this headline">¶</a></h2>
	<p>The locale of the current user is stored in the session and is accessible
	  via the <tt class="docutils literal"><span class="pre">session</span></tt> service:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$locale</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'session'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getLocale</span><span class="p">();</span>

<span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'session'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">setLocale</span><span class="p">(</span><span class="s1">'en_US'</span><span class="p">);</span>
	  </pre></div>
	</div>
	<div class="section" id="fallback-and-default-locale">
	  <span id="index-9"></span><h3>Fallback and Default Locale<a class="headerlink" href="#fallback-and-default-locale" title="Permalink to this headline">¶</a></h3>
	  <p>If the locale hasn't been set explicitly in the session, the <tt class="docutils literal"><span class="pre">fallback_locale</span></tt>
	    configuration parameter will be used by the <tt class="docutils literal"><span class="pre">Translator</span></tt>. The parameter
	    defaults to <tt class="docutils literal"><span class="pre">en</span></tt> (see <a class="reference internal" href="#configuration">Configuration</a>).</p>
	  <p>Alternatively, you can guarantee that a locale is set on the user's session
	    by defining a <tt class="docutils literal"><span class="pre">default_locale</span></tt> for the session service:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 112px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">framework</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">session</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">default_locale</span><span class="p-Indicator">:</span> <span class="nv">en</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;framework:config&gt;</span>
    <span class="nt">&lt;framework:session</span> <span class="na">default-locale=</span><span class="s">"en"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/framework:config&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'session'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'default_locale'</span> <span class="o">=&gt;</span> <span class="s1">'en'</span><span class="p">),</span>
<span class="p">));</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	</div>
	<div class="section" id="the-locale-and-the-url">
	  <h3>The Locale and the URL<a class="headerlink" href="#the-locale-and-the-url" title="Permalink to this headline">¶</a></h3>
	  <p>Since the locale of the user is stored in the session, it may be tempting
	    to use the same URL to display a resource in many different languages based
	    on the user's locale. For example, <tt class="docutils literal"><span class="pre">http://www.example.com/contact</span></tt> could
	    show content in English for one user and French for another user. Unfortunately,
	    this violates a fundamental rule of the Web: that a particular URL returns
	    the same resource regardless of the user. To further muddy the problem, which
	    version of the content would be indexed by search engines?</p>
	  <p>A better policy is to include the locale in the URL. This is fully-supported
	    by the routing system using the special <tt class="docutils literal"><span class="pre">_locale</span></tt> parameter:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 148px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">contact</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/{_locale}/contact</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span>  <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeDemoBundle</span><span class="p-Indicator">:</span><span class="nv">Contact</span><span class="p-Indicator">:</span><span class="nv">index</span><span class="p-Indicator">,</span> <span class="nv">_locale</span><span class="p-Indicator">:</span> <span class="nv">en</span> <span class="p-Indicator">}</span>
    <span class="l-Scalar-Plain">requirements</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">_locale</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">en|fr|de</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"contact"</span> <span class="na">pattern=</span><span class="s">"/{_locale}/contact"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeDemoBundle:Contact:index<span class="nt">&lt;/default&gt;</span>
    <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_locale"</span><span class="nt">&gt;</span>en<span class="nt">&lt;/default&gt;</span>
    <span class="nt">&lt;requirement</span> <span class="na">key=</span><span class="s">"_locale"</span><span class="nt">&gt;</span>en|fr|de<span class="nt">&lt;/requirement&gt;</span>
<span class="nt">&lt;/route&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'contact'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/{_locale}/contact'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeDemoBundle:Contact:index'</span><span class="p">,</span>
    <span class="s1">'_locale'</span>     <span class="o">=&gt;</span> <span class="s1">'en'</span><span class="p">,</span>
<span class="p">),</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_locale'</span>     <span class="o">=&gt;</span> <span class="s1">'en|fr|de'</span>
<span class="p">)));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>When using the special <cite>_locale</cite> parameter in a route, the matched locale
	    will <em>automatically be set on the user's session</em>. In other words, if a user
	    visits the URI <tt class="docutils literal"><span class="pre">/fr/contact</span></tt>, the locale <tt class="docutils literal"><span class="pre">fr</span></tt> will automatically be set
	    as the locale for the user's session.</p>
	  <p>You can now use the user's locale to create routes to other translated pages
	    in your application.</p>
	</div>
      </div>
      <div class="section" id="pluralization">
	<span id="index-10"></span><h2>Pluralization<a class="headerlink" href="#pluralization" title="Permalink to this headline">¶</a></h2>
	<p>Message pluralization is a tough topic as the rules can be quite complex. For
	  instance, here is the mathematic representation of the Russian pluralization
	  rules:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="p">((</span><span class="nv">$number</span> <span class="o">%</span> <span class="mi">10</span> <span class="o">==</span> <span class="mi">1</span><span class="p">)</span> <span class="o">&amp;&amp;</span> <span class="p">(</span><span class="nv">$number</span> <span class="o">%</span> <span class="mi">100</span> <span class="o">!=</span> <span class="mi">11</span><span class="p">))</span> <span class="o">?</span> <span class="mi">0</span> <span class="o">:</span> <span class="p">(((</span><span class="nv">$number</span> <span class="o">%</span> <span class="mi">10</span> <span class="o">&gt;=</span> <span class="mi">2</span><span class="p">)</span> <span class="o">&amp;&amp;</span> <span class="p">(</span><span class="nv">$number</span> <span class="o">%</span> <span class="mi">10</span> <span class="o">&lt;=</span> <span class="mi">4</span><span class="p">)</span> <span class="o">&amp;&amp;</span> <span class="p">((</span><span class="nv">$number</span> <span class="o">%</span> <span class="mi">100</span> <span class="o">&lt;</span> <span class="mi">10</span><span class="p">)</span> <span class="o">||</span> <span class="p">(</span><span class="nv">$number</span> <span class="o">%</span> <span class="mi">100</span> <span class="o">&gt;=</span> <span class="mi">20</span><span class="p">)))</span> <span class="o">?</span> <span class="mi">1</span> <span class="o">:</span> <span class="mi">2</span><span class="p">);</span>
	  </pre></div>
	</div>
	<p>As you can see, in Russian, you can have three different plural forms, each
	  given an index of 0, 1 or 2. For each form, the plural is different, and
	  so the translation is also different.</p>
	<p>When a translation has different forms due to pluralization, you can provide
	  all the forms as a string separated by a pipe (<tt class="docutils literal"><span class="pre">|</span></tt>):</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="s1">'There is one apple|There are %count% apples'</span>
	  </pre></div>
	</div>
	<p>To translate pluralized messages, use the
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Translation/Translator.html#transChoice()" title="Symfony\Component\Translation\Translator::transChoice()"><span class="pre">transChoice()</span></a></tt> method:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$t</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'translator'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">transChoice</span><span class="p">(</span>
    <span class="s1">'There is one apple|There are %count% apples'</span><span class="p">,</span>
    <span class="mi">10</span><span class="p">,</span>
    <span class="k">array</span><span class="p">(</span><span class="s1">'%count%'</span> <span class="o">=&gt;</span> <span class="mi">10</span><span class="p">)</span>
<span class="p">);</span>
	  </pre></div>
	</div>
	<p>The second argument (<tt class="docutils literal"><span class="pre">10</span></tt> in this example), is the <em>number</em> of objects being
	  described and is used to determine which translation to use and also to populate
	  the <tt class="docutils literal"><span class="pre">%count%</span></tt> placeholder.</p>
	<p>Based on the given number, the translator chooses the right plural form.
	  In English, most words have a singular form when there is exactly one object
	  and a plural form for all other numbers (0, 2, 3...). So, if <tt class="docutils literal"><span class="pre">count</span></tt> is
	  <tt class="docutils literal"><span class="pre">1</span></tt>, the translator will use the first string (<tt class="docutils literal"><span class="pre">There</span> <span class="pre">is</span> <span class="pre">one</span> <span class="pre">apple</span></tt>)
	  as the translation. Otherwise it will use <tt class="docutils literal"><span class="pre">There</span> <span class="pre">are</span> <span class="pre">%count%</span> <span class="pre">apples</span></tt>.</p>
	<p>Here is the French translation:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="s1">'Il y a %count% pomme|Il y a %count% pommes'</span>
	  </pre></div>
	</div>
	<p>Even if the string looks similar (it is made of two sub-strings separated by a
	  pipe), the French rules are different: the first form (no plural) is used when
	  <tt class="docutils literal"><span class="pre">count</span></tt> is <tt class="docutils literal"><span class="pre">0</span></tt> or <tt class="docutils literal"><span class="pre">1</span></tt>. So, the translator will automatically use the
	  first string (<tt class="docutils literal"><span class="pre">Il</span> <span class="pre">y</span> <span class="pre">a</span> <span class="pre">%count%</span> <span class="pre">pomme</span></tt>) when <tt class="docutils literal"><span class="pre">count</span></tt> is <tt class="docutils literal"><span class="pre">0</span></tt> or <tt class="docutils literal"><span class="pre">1</span></tt>.</p>
	<p>Each locale has its own set of rules, with some having as many as six different
	  plural forms with complex rules behind which numbers map to which plural form.
	  The rules are quite simple for English and French, but for Russian, you'd
	  may want a hint to know which rule matches which string. To help translators,
	  you can optionally "tag" each string:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="s1">'one: There is one apple|some: There are %count% apples'</span>

<span class="s1">'none_or_one: Il y a %count% pomme|some: Il y a %count% pommes'</span>
	  </pre></div>
	</div>
	<p>The tags are really only hints for translators and don't affect the logic
	  used to determine which plural form to use. The tags can be any descriptive
	  string that ends with a colon (<tt class="docutils literal"><span class="pre">:</span></tt>). The tags also do not need to be the
	  same in the original message as in the translated one.</p>
	<div class="section" id="explicit-interval-pluralization">
	  <h3>Explicit Interval Pluralization<a class="headerlink" href="#explicit-interval-pluralization" title="Permalink to this headline">¶</a></h3>
	  <p>The easiest way to pluralize a message is to let Symfony2 use internal logic
	    to choose which string to use based on a given number. Sometimes, you'll
	    need more control or want a different translation for specific cases (for
	    <tt class="docutils literal"><span class="pre">0</span></tt>, or when the count is negative, for example). For such cases, you can
	    use explicit math intervals:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="s1">'{0} There is no apples|{1} There is one apple|]1,19] There are %count% apples|[20,Inf] There are many apples'</span>
	    </pre></div>
	  </div>
	  <p>The intervals follow the <a class="reference external" href="http://en.wikipedia.org/wiki/Interval_%28mathematics%29#The_ISO_notation">ISO 31-11</a> notation. The above string specifies
	    four different intervals: exactly <tt class="docutils literal"><span class="pre">0</span></tt>, exactly <tt class="docutils literal"><span class="pre">1</span></tt>, <tt class="docutils literal"><span class="pre">2-19</span></tt>, and <tt class="docutils literal"><span class="pre">20</span></tt>
	    and higher.</p>
	  <p>You can also mix explicit math rules and standard rules. In this case, if
	    the count is not matched by a specific interval, the standard rules take
	    effect after removing the explicit rules:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="s1">'{0} There is no apples|[20,Inf] There are many apples|There is one apple|a_few: There are %count% apples'</span>
	    </pre></div>
	  </div>
	  <p>For example, for <tt class="docutils literal"><span class="pre">1</span></tt> apple, the standard rule <tt class="docutils literal"><span class="pre">There</span> <span class="pre">is</span> <span class="pre">one</span> <span class="pre">apple</span></tt> will
	    be used. For <tt class="docutils literal"><span class="pre">2-19</span></tt> apples, the second standard rule <tt class="docutils literal"><span class="pre">There</span> <span class="pre">are</span> <span class="pre">%count%</span>
	      <span class="pre">apples</span></tt> will be selected.</p>
	  <p>An <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Translation/Interval.html" title="Symfony\Component\Translation\Interval"><span class="pre">Interval</span></a></tt> can represent a finite set
	    of numbers:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="p">{</span><span class="mi">1</span><span class="p">,</span><span class="mi">2</span><span class="p">,</span><span class="mi">3</span><span class="p">,</span><span class="mi">4</span><span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Or numbers between two other numbers:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="p">[</span><span class="mi">1</span><span class="p">,</span> <span class="o">+</span><span class="nx">Inf</span><span class="p">[</span>
<span class="p">]</span><span class="o">-</span><span class="mi">1</span><span class="p">,</span><span class="mi">2</span><span class="p">[</span>
	    </pre></div>
	  </div>
	  <p>The left delimiter can be <tt class="docutils literal"><span class="pre">[</span></tt> (inclusive) or <tt class="docutils literal"><span class="pre">]</span></tt> (exclusive). The right
	    delimiter can be <tt class="docutils literal"><span class="pre">[</span></tt> (exclusive) or <tt class="docutils literal"><span class="pre">]</span></tt> (inclusive). Beside numbers, you
	    can use <tt class="docutils literal"><span class="pre">-Inf</span></tt> and <tt class="docutils literal"><span class="pre">+Inf</span></tt> for the infinite.</p>
	</div>
      </div>
      <div class="section" id="translations-in-templates">
	<span id="index-11"></span><h2>Translations in Templates<a class="headerlink" href="#translations-in-templates" title="Permalink to this headline">¶</a></h2>
	<p>Most of the time, translation occurs in templates. Symfony2 provides native
	  support for both Twig and PHP templates.</p>
	<div class="section" id="twig-templates">
	  <h3>Twig Templates<a class="headerlink" href="#twig-templates" title="Permalink to this headline">¶</a></h3>
	  <p>Symfony2 provides specialized Twig tags (<tt class="docutils literal"><span class="pre">trans</span></tt> and <tt class="docutils literal"><span class="pre">transchoice</span></tt>) to
	    help with message translation of <em>static blocks of text</em>:</p>
	  <div class="highlight-jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">trans</span> <span class="cp">%}</span><span class="x">Hello %name%</span><span class="cp">{%</span> <span class="k">endtrans</span> <span class="cp">%}</span><span class="x"></span>

<span class="cp">{%</span> <span class="k">transchoice</span> <span class="nv">count</span> <span class="cp">%}</span><span class="x"></span>
<span class="x">    {0} There is no apples|{1} There is one apple|]1,Inf] There are %count% apples</span>
<span class="cp">{%</span> <span class="k">endtranschoice</span> <span class="cp">%}</span><span class="x"></span>
	    </pre></div>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">transchoice</span></tt> tag automatically gets the <tt class="docutils literal"><span class="pre">%count%</span></tt> variable from
	    the current context and passes it to the translator. This mechanism only
	    works when you use a placeholder following the <tt class="docutils literal"><span class="pre">%var%</span></tt> pattern.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">If you need to use the percent character (<tt class="docutils literal"><span class="pre">%</span></tt>) in a string, escape it by
		doubling it: <tt class="docutils literal"><span class="pre">{%</span> <span class="pre">trans</span> <span class="pre">%}Percent:</span> <span class="pre">%percent%%%{%</span> <span class="pre">endtrans</span> <span class="pre">%}</span></tt></p>
	  </div></div>
	  <p>You can also specify the message domain and pass some additional variables:</p>
	  <div class="highlight-jinja"><div class="highlight"><pre><span class="cp">{%</span> <span class="k">trans</span> <span class="k">with</span> <span class="o">{</span><span class="s1">'%name%'</span><span class="o">:</span> <span class="s1">'Fabien'</span><span class="o">}</span> <span class="nv">from</span> <span class="s2">"app"</span> <span class="cp">%}</span><span class="x">Hello %name%</span><span class="cp">{%</span> <span class="k">endtrans</span> <span class="cp">%}</span><span class="x"></span>

<span class="cp">{%</span> <span class="k">transchoice</span> <span class="nv">count</span> <span class="k">with</span> <span class="o">{</span><span class="s1">'%name%'</span><span class="o">:</span> <span class="s1">'Fabien'</span><span class="o">}</span> <span class="nv">from</span> <span class="s2">"app"</span> <span class="cp">%}</span><span class="x"></span>
<span class="x">    {0} There is no apples|{1} There is one apple|]1,Inf] There are %count% apples</span>
<span class="cp">{%</span> <span class="k">endtranschoice</span> <span class="cp">%}</span><span class="x"></span>
	    </pre></div>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">trans</span></tt> and <tt class="docutils literal"><span class="pre">transchoice</span></tt> filters can be used to translate <em>variable
	      texts</em> and complex expressions:</p>
	  <div class="highlight-jinja"><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">message</span> <span class="o">|</span> <span class="nf">trans</span> <span class="cp">}}</span><span class="x"></span>

<span class="cp">{{</span> <span class="nv">message</span> <span class="o">|</span> <span class="nf">transchoice</span><span class="o">(</span><span class="m">5</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>

<span class="cp">{{</span> <span class="nv">message</span> <span class="o">|</span> <span class="nf">trans</span><span class="o">({</span><span class="s1">'%name%'</span><span class="o">:</span> <span class="s1">'Fabien'</span><span class="o">},</span> <span class="s2">"app"</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>

<span class="cp">{{</span> <span class="nv">message</span> <span class="o">|</span> <span class="nf">transchoice</span><span class="o">(</span><span class="m">5</span><span class="o">,</span> <span class="o">{</span><span class="s1">'%name%'</span><span class="o">:</span> <span class="s1">'Fabien'</span><span class="o">},</span> <span class="s1">'app'</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p>Using the translation tags or filters have the same effect, but with
		one subtle difference: automatic output escaping is only applied to
		variables translated using a filter. In other words, if you need to
		be sure that your translated variable is <em>not</em> output escaped, you must
		apply the raw filter after the translation filter:</p>
	      <div class="last highlight-jinja"><div class="highlight"><pre><span class="c">{# text translated between tags is never escaped #}</span><span class="x"></span>
<span class="cp">{%</span> <span class="k">trans</span> <span class="cp">%}</span><span class="x"></span>
<span class="x">    &lt;h3&gt;foo&lt;/h3&gt;</span>
<span class="cp">{%</span> <span class="k">endtrans</span> <span class="cp">%}</span><span class="x"></span>

<span class="cp">{%</span> <span class="k">set</span> <span class="nv">message</span> <span class="o">=</span> <span class="s1">'&lt;h3&gt;foo&lt;/h3&gt;'</span> <span class="cp">%}</span><span class="x"></span>

<span class="c">{# a variable translated via a filter is escaped by default #}</span><span class="x"></span>
<span class="cp">{{</span> <span class="nv">message</span> <span class="o">|</span> <span class="nf">trans</span> <span class="o">|</span> <span class="nf">raw</span> <span class="cp">}}</span><span class="x"></span>

<span class="c">{# but static strings are never escaped #}</span><span class="x"></span>
<span class="cp">{{</span> <span class="s1">'&lt;h3&gt;foo&lt;/h3&gt;'</span> <span class="o">|</span> <span class="nf">trans</span> <span class="cp">}}</span><span class="x"></span>
		</pre></div>
	      </div>
	  </div></div>
	</div>
	<div class="section" id="php-templates">
	  <h3>PHP Templates<a class="headerlink" href="#php-templates" title="Permalink to this headline">¶</a></h3>
	  <p>The translator service is accessible in PHP templates through the
	    <tt class="docutils literal"><span class="pre">translator</span></tt> helper:</p>
	  <div class="highlight-html+php"><div class="highlight"><pre><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'translator'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">trans</span><span class="p">(</span><span class="s1">'Symfony2 is great'</span><span class="p">)</span> <span class="cp">?&gt;</span>

<span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'translator'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">transChoice</span><span class="p">(</span>
    <span class="s1">'{0} There is no apples|{1} There is one apple|]1,Inf[ There are %count% apples'</span><span class="p">,</span>
    <span class="mi">10</span><span class="p">,</span>
    <span class="k">array</span><span class="p">(</span><span class="s1">'%count%'</span> <span class="o">=&gt;</span> <span class="mi">10</span><span class="p">)</span>
<span class="p">)</span> <span class="cp">?&gt;</span>
	    </pre></div>
	  </div>
	</div>
      </div>
      <div class="section" id="forcing-translation-locale">
	<h2>Forcing Translation Locale<a class="headerlink" href="#forcing-translation-locale" title="Permalink to this headline">¶</a></h2>
	<p>When translating a message, Symfony2 uses the locale from the user's session
	  or the <tt class="docutils literal"><span class="pre">fallback</span></tt> locale if necessary. You can also manually specify the
	  locale to use for translation:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'translation'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">trans</span><span class="p">(</span>
    <span class="s1">'Symfony2 is great'</span><span class="p">,</span>
    <span class="k">array</span><span class="p">(),</span>
    <span class="s1">'messages'</span><span class="p">,</span>
    <span class="s1">'fr_FR'</span><span class="p">,</span>
<span class="p">);</span>

<span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'translation'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">trans</span><span class="p">(</span>
    <span class="s1">'{0} There is no apples|{1} There is one apple|]1,Inf[ There are %count% apples'</span><span class="p">,</span>
    <span class="mi">10</span><span class="p">,</span>
    <span class="k">array</span><span class="p">(</span><span class="s1">'%count%'</span> <span class="o">=&gt;</span> <span class="mi">10</span><span class="p">),</span>
    <span class="s1">'messages'</span><span class="p">,</span>
    <span class="s1">'fr_FR'</span><span class="p">,</span>
<span class="p">);</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="translating-database-content">
	<h2>Translating Database Content<a class="headerlink" href="#translating-database-content" title="Permalink to this headline">¶</a></h2>
	<p>The translation of database content should be handled by Doctrine through
	  the <a class="reference external" href="https://github.com/l3pp4rd/DoctrineExtensions">Translatable Extension</a>. For more information, see the documentation
	  for that library.</p>
      </div>
      <div class="section" id="summary">
	<h2>Summary<a class="headerlink" href="#summary" title="Permalink to this headline">¶</a></h2>
	<p>With the Symfony2 Translation component, creating an internationalized application
	  no longer needs to be a painful process and boils down to just a few basic
	  steps:</p>
	<ul class="simple">
	  <li>Abstract messages in your application by wrapping each in either the
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Translation/Translator.html#trans()" title="Symfony\Component\Translation\Translator::trans()"><span class="pre">trans()</span></a></tt> or
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Translation/Translator.html#transChoice()" title="Symfony\Component\Translation\Translator::transChoice()"><span class="pre">transChoice()</span></a></tt> methods;</li>
	  <li>Translate each message into multiple locales by creating translation message
	    files. Symfony2 discovers and processes each file because its name follows
	    a specific convention;</li>
	  <li>Manage the user's locale, which is stored in the session.</li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="HTTP Cache" href="http_cache.html">
      «&nbsp;HTTP Cache
    </a><span class="separator">|</span>
    <a accesskey="N" title="Bundles" href="bundles.html">
      Bundles&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
