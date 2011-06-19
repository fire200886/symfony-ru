<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Validation</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="validation">
      <span id="index-0"></span><h1>Validation<a class="headerlink" href="#validation" title="Permalink to this headline">¶</a></h1>
      <p>Validation is a very common task in web applications. Data entered in forms
	needs to be validated. Data also needs to be validated before it is written
	into a database or passed to a web service.</p>
      <p>Symfony2 ships with a <a class="reference external" href="https://github.com/symfony/Validator">Validator</a> component that makes this task easy and transparent.
	This component is based on the <a class="reference external" href="http://jcp.org/en/jsr/detail?id=303">JSR303 Bean Validation specification</a>. What?
	A Java specification in PHP? You heard right, but it's not as bad as it sounds.
	Let's look at how it can be used in PHP.</p>
      <div class="section" id="the-basics-of-validation">
	<h2>The Basics of Validation<a class="headerlink" href="#the-basics-of-validation" title="Permalink to this headline">¶</a></h2>
	<p>The best way to understand validation is to see it in action. To start, suppose
	  you've created a plain-old-PHP object that you need to use somewhere in
	  your application:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="nv">$name</span><span class="p">;</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>So far, this is just an ordinary class that serves some purpose inside your
	  application. The goal of validation is to tell you whether or not the data
	  of an object is valid. For this to work, you need to configure a list of
	  rules (called <a class="reference internal" href="#validation-constraints"><em>constraints</em></a>) that the object
	  must follow in order to be valid. These rules can be specified via a number
	  of different formats (YAML, XML, annotations, or PHP). To guarantee that
	  the <tt class="docutils literal"><span class="pre">$name</span></tt> property is not empty, add the following:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 148px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># Acme/BlogBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\BlogBundle\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">name</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">NotBlank</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- Acme/BlogBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\BlogBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"name"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"NotBlank"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
<span class="nt">&lt;/class&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Assert\NotBlank()</span>
<span class="sd">     */</span>
    <span class="k">public</span> <span class="nv">$name</span><span class="p">;</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\NotBlank</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="nv">$name</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'name'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">NotBlank</span><span class="p">());</span>
    <span class="p">}</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Protected and private properties can also be validated, as well as "getter"
	      methods (see <cite>validator-constraint-targets</cite>).</p>
	</div></div>
	<div class="section" id="using-the-validator-service">
	  <span id="index-1"></span><h3>Using the <tt class="docutils literal"><span class="pre">validator</span></tt> Service<a class="headerlink" href="#using-the-validator-service" title="Permalink to this headline">¶</a></h3>
	  <p>To actually validate an <tt class="docutils literal"><span class="pre">Author</span></tt> object, use the <tt class="docutils literal"><span class="pre">validate</span></tt> method
	    on the <tt class="docutils literal"><span class="pre">validator</span></tt> service (class <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Validator/Validator.html" title="Symfony\Component\Validator\Validator"><span class="pre">Validator</span></a></tt>).
	    The job of the <tt class="docutils literal"><span class="pre">validator</span></tt> is easy: to read the constraints (i.e. rules)
	    of a class and verify whether or not the data on the object satisfies those
	    constraints. If validation fails, an array of errors is returned. Take this
	    simple example from inside a controller:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Response</span><span class="p">;</span>
<span class="c1">// ...</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$author</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Acme\BlogBundle\Author</span><span class="p">();</span>
    <span class="c1">// ... do something to the $author object</span>

    <span class="nv">$validator</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'validator'</span><span class="p">);</span>
    <span class="nv">$errorList</span> <span class="o">=</span> <span class="nv">$validator</span><span class="o">-&gt;</span><span class="na">validate</span><span class="p">(</span><span class="nv">$author</span><span class="p">);</span>

    <span class="k">if</span> <span class="p">(</span><span class="nb">count</span><span class="p">(</span><span class="nv">$errorList</span><span class="p">)</span> <span class="o">&gt;</span> <span class="mi">0</span><span class="p">)</span> <span class="p">{</span>
        <span class="k">return</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="nb">print_r</span><span class="p">(</span><span class="nv">$errorList</span><span class="p">,</span> <span class="k">true</span><span class="p">));</span>
    <span class="p">}</span> <span class="k">else</span> <span class="p">{</span>
        <span class="k">return</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="s1">'The author is valid! Yes!'</span><span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>If the <tt class="docutils literal"><span class="pre">$name</span></tt> property is empty, you will see the following error
	    message:</p>
	  <div class="highlight-text"><div class="highlight"><pre>Acme\BlogBundle\Author.name:
    This value should not be blank
	    </pre></div>
	  </div>
	  <p>If you insert a value into the <tt class="docutils literal"><span class="pre">name</span></tt> property, the happy success message
	    will appear.</p>
	  <p>Each validation error (called a "constraint violation"), is represented by
	    a <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Validator/ConstraintViolation.html" title="Symfony\Component\Validator\ConstraintViolation"><span class="pre">ConstraintViolation</span></a></tt> object, which
	    holds a message describing the error. Moreover, the <tt class="docutils literal"><span class="pre">validate</span></tt> method returns
	    a <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Validator/ConstraintViolationList.html" title="Symfony\Component\Validator\ConstraintViolationList"><span class="pre">ConstraintViolationList</span></a></tt> object,
	    which acts like an array. That's a long way of saying that you can use the
	    errors returned by <tt class="docutils literal"><span class="pre">validate</span></tt> in more advanced ways. Start by rendering
	    a template and passing in the <tt class="docutils literal"><span class="pre">$errorList</span></tt> variable:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">if</span> <span class="p">(</span><span class="nb">count</span><span class="p">(</span><span class="nv">$errorList</span><span class="p">)</span> <span class="o">&gt;</span> <span class="mi">0</span><span class="p">)</span> <span class="p">{</span>
    <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeBlogBundle:Author:validate.html.twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'errorList'</span> <span class="o">=&gt;</span> <span class="nv">$errorList</span><span class="p">,</span>
    <span class="p">));</span>
<span class="p">}</span> <span class="k">else</span> <span class="p">{</span>
    <span class="c1">// ...</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Inside the template, you can output the list of errors exactly as needed:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 202px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">{# src/Acme/BlogBundle/Resources/views/Author/validate.html.twig #}</span>

<span class="nt">&lt;h3&gt;</span>The author has the following errors<span class="nt">&lt;/h3&gt;</span>
<span class="nt">&lt;ul&gt;</span>
<span class="cp">{%</span> <span class="k">for</span> <span class="nv">error</span> <span class="k">in</span> <span class="nv">errorList</span> <span class="cp">%}</span>
    <span class="nt">&lt;li&gt;</span><span class="cp">{{</span> <span class="nv">error.message</span> <span class="cp">}}</span><span class="nt">&lt;/li&gt;</span>
<span class="cp">{%</span> <span class="k">endfor</span> <span class="cp">%}</span>
<span class="nt">&lt;/ul&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-html+php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/BlogBundle/Resources/views/Author/validate.html.php --&gt;</span>

<span class="nt">&lt;h3&gt;</span>The author has the following errors<span class="nt">&lt;/h3&gt;</span>
<span class="nt">&lt;ul&gt;</span>
<span class="cp">&lt;?php</span> <span class="k">foreach</span> <span class="p">(</span><span class="nv">$errorList</span> <span class="k">as</span> <span class="nv">$error</span><span class="p">)</span><span class="o">:</span> <span class="cp">?&gt;</span>
    <span class="nt">&lt;li&gt;</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$error</span><span class="o">-&gt;</span><span class="na">getMessage</span><span class="p">()</span> <span class="cp">?&gt;</span><span class="nt">&lt;/li&gt;</span>
<span class="cp">&lt;?php</span> <span class="k">endforeach</span><span class="p">;</span> <span class="cp">?&gt;</span>
<span class="nt">&lt;/ul&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	</div>
	<div class="section" id="validation-and-forms">
	  <span id="index-2"></span><h3>Validation and Forms<a class="headerlink" href="#validation-and-forms" title="Permalink to this headline">¶</a></h3>
	  <p>The <tt class="docutils literal"><span class="pre">validator</span></tt> service can be used at any time to validate any object.
	    In reality, however, you'll usually work with the <tt class="docutils literal"><span class="pre">validator</span></tt> indirectly
	    via the <tt class="docutils literal"><span class="pre">Form</span></tt> class. The <tt class="docutils literal"><span class="pre">Form</span></tt> class uses the <tt class="docutils literal"><span class="pre">validator</span></tt> service
	    internally to validate the underlying object after values have been submitted
	    and bound. The constraint violations on the object are converted into <tt class="docutils literal"><span class="pre">FieldError</span></tt>
	    objects that can then be displayed with your form:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$author</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Acme\BlogBundle\Author</span><span class="p">();</span>
<span class="nv">$form</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Acme\BlogBundle\AuthorForm</span><span class="p">(</span><span class="s1">'author'</span><span class="p">,</span> <span class="nv">$author</span><span class="p">,</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'validator'</span><span class="p">));</span>
<span class="nv">$form</span><span class="o">-&gt;</span><span class="na">bind</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'request'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">request</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'customer'</span><span class="p">));</span>

<span class="k">if</span> <span class="p">(</span><span class="nv">$form</span><span class="o">-&gt;</span><span class="na">isValid</span><span class="p">())</span> <span class="p">{</span>
    <span class="c1">// process the Author object</span>
<span class="p">}</span> <span class="k">else</span> <span class="p">{</span>
    <span class="c1">// render the template with the errors</span>
    <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'BlogBundle:Author:form.html.twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'form'</span> <span class="o">=&gt;</span> <span class="nv">$form</span><span class="p">));</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>For more information, see the <a class="reference internal" href="forms.html"><em>Forms</em></a> chapter.</p>
	</div>
      </div>
      <div class="section" id="configuration">
	<span id="index-3"></span><h2>Configuration<a class="headerlink" href="#configuration" title="Permalink to this headline">¶</a></h2>
	<p>To use the Symfony2 validator, ensure that it's enabled in your application
	  configuration:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 112px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">framework</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">validation</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">enabled</span><span class="p-Indicator">:</span> <span class="nv">true</span><span class="p-Indicator">,</span> <span class="nv">enable_annotations</span><span class="p-Indicator">:</span> <span class="nv">true</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;framework:config&gt;</span>
    <span class="nt">&lt;framework:validation</span> <span class="na">enabled=</span><span class="s">"true"</span> <span class="na">enable_annotations=</span><span class="s">"true"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/framework:config&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'validation'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'enabled'</span>     <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
    <span class="s1">'enable_annotations'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">The <tt class="docutils literal"><span class="pre">annotations</span></tt> configuration needs to be set to <tt class="docutils literal"><span class="pre">true</span></tt> only if
	      you're mapping constraints via annotations.</p>
	</div></div>
      </div>
      <div class="section" id="constraints">
	<span id="validation-constraints"></span><span id="index-4"></span><h2>Constraints<a class="headerlink" href="#constraints" title="Permalink to this headline">¶</a></h2>
	<p>The <tt class="docutils literal"><span class="pre">validator</span></tt> is designed to validate objects against <em>constraints</em> (i.e.
	  rules). In order to validate an object, simply map one or more constraints
	  to its class and then pass it to the <tt class="docutils literal"><span class="pre">validator</span></tt> service.</p>
	<p>A constraint is simply a PHP object that makes an assertive statement. In
	  real life, a constraint could be: "The cake must not be burned". In Symfony2,
	  constraints are similar: they are assertions that a condition is true. Given
	  a value, a constraint will tell you whether or not that value adheres to
	  the rules of the constraint.</p>
	<div class="section" id="supported-constraints">
	  <h3>Supported Constraints<a class="headerlink" href="#supported-constraints" title="Permalink to this headline">¶</a></h3>
	  <p>Symfony2 packages a large number of the most commonly-needed constraints.
	    The full list of constraints with details is available in the
	    <a class="reference internal" href="../reference/constraints.html"><em>constraints reference section</em></a>.</p>
	</div>
	<div class="section" id="constraint-configuration">
	  <span id="index-5"></span><h3>Constraint Configuration<a class="headerlink" href="#constraint-configuration" title="Permalink to this headline">¶</a></h3>
	  <p>Some constraints, like <a class="reference internal" href="../reference/constraints/NotBlank.html"><em>NotBlank</em></a>,
	    are simple whereas others, like the <a class="reference internal" href="../reference/constraints/Choice.html"><em>Choice</em></a>
	    constraint, have several configuration options available. The available
	    options are public properties on the constraint and each can be set by passing
	    an options array to the constraint. Suppose that the <tt class="docutils literal"><span class="pre">Author</span></tt> class has
	    another property, <tt class="docutils literal"><span class="pre">gender</span></tt> that can be set to either "male" or "female":</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 148px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># Acme/BlogBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\BlogBundle\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">gender</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Choice</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">choices</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span><span class="nv">male</span><span class="p-Indicator">,</span> <span class="nv">female</span><span class="p-Indicator">],</span> <span class="nv">message</span><span class="p-Indicator">:</span> <span class="nv">Choose a valid gender.</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- Acme/BlogBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\BlogBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"gender"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"Choice"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;option</span> <span class="na">name=</span><span class="s">"choices"</span><span class="nt">&gt;</span>
                <span class="nt">&lt;value&gt;</span>male<span class="nt">&lt;/value&gt;</span>
                <span class="nt">&lt;value&gt;</span>female<span class="nt">&lt;/value&gt;</span>
            <span class="nt">&lt;/option&gt;</span>
            <span class="nt">&lt;option</span> <span class="na">name=</span><span class="s">"message"</span><span class="nt">&gt;</span>Choose a valid gender.<span class="nt">&lt;/option&gt;</span>
        <span class="nt">&lt;/constraint&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
<span class="nt">&lt;/class&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Assert\Choice(</span>
<span class="sd">     *     choices = { "male", "female" },</span>
<span class="sd">     *     message = "Choose a valid gender."</span>
<span class="sd">     * )</span>
<span class="sd">     */</span>
    <span class="k">public</span> <span class="nv">$gender</span><span class="p">;</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\NotBlank</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="nv">$gender</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'gender'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Choice</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
            <span class="s1">'choices'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'male'</span><span class="p">,</span> <span class="s1">'female'</span><span class="p">),</span>
            <span class="s1">'message'</span> <span class="o">=&gt;</span> <span class="s1">'Choose a valid gender.'</span><span class="p">,</span>
        <span class="p">));</span>
    <span class="p">}</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>The options of a constraint can always be passed in as an array. Some constraints
	    also allow you to pass the value of one, "default", option to the constraint
	    in place of the array. In the case of the <tt class="docutils literal"><span class="pre">Choice</span></tt> constraint, the <tt class="docutils literal"><span class="pre">choices</span></tt>
	    options can be specified in this way.</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 148px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># Acme/BlogBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\BlogBundle\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">gender</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Choice</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span><span class="nv">male</span><span class="p-Indicator">,</span> <span class="nv">female</span><span class="p-Indicator">]</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- Acme/BlogBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\BlogBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"gender"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"Choice"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;value&gt;</span>male<span class="nt">&lt;/value&gt;</span>
            <span class="nt">&lt;value&gt;</span>female<span class="nt">&lt;/value&gt;</span>
        <span class="nt">&lt;/constraint&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
<span class="nt">&lt;/class&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Assert\Choice({"male", "female"})</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$gender</span><span class="p">;</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\Choice</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$gender</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'gender'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Choice</span><span class="p">(</span><span class="k">array</span><span class="p">(</span><span class="s1">'male'</span><span class="p">,</span> <span class="s1">'female'</span><span class="p">)));</span>
    <span class="p">}</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Be sure not to let the two different methods of specifying options confuse
	    you. If you're unsure, either check the API documentation for the constraint
	    or play it safe by always passing in an array of options (the first method
	    shown above).</p>
	</div>
      </div>
      <div class="section" id="constraint-targets">
	<span id="validator-constraint-targets"></span><span id="index-6"></span><h2>Constraint Targets<a class="headerlink" href="#constraint-targets" title="Permalink to this headline">¶</a></h2>
	<p>Constraints can be applied to a class property or a public getter method
	  (e.g. <tt class="docutils literal"><span class="pre">getFullName</span></tt>).</p>
	<div class="section" id="properties">
	  <span id="index-7"></span><h3>Properties<a class="headerlink" href="#properties" title="Permalink to this headline">¶</a></h3>
	  <p>Validating class properties is the most basic validation technique. Symfony2
	    allows you to validate private, protected or public properties. The next
	    listing shows you how to configure the properties <tt class="docutils literal"><span class="pre">$firstName</span></tt> and <tt class="docutils literal"><span class="pre">$lastName</span></tt>
	    of a class <tt class="docutils literal"><span class="pre">Author</span></tt> to have at least 3 characters.</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 220px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># Acme/BlogBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\BlogBundle\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">firstName</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">NotBlank</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">MinLength</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">3</span>
        <span class="l-Scalar-Plain">lastName</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">NotBlank</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">MinLength</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">3</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- Acme/BlogBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\BlogBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"firstName"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"NotBlank"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"MinLength"</span><span class="nt">&gt;</span>3<span class="nt">&lt;/constraint&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"lastName"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"NotBlank"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"MinLength"</span><span class="nt">&gt;</span>3<span class="nt">&lt;/constraint&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
<span class="nt">&lt;/class&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Assert\NotBlank()</span>
<span class="sd">     * @Assert\MinLength(3)</span>
<span class="sd">     */</span>
    <span class="k">private</span> <span class="nv">$firstName</span><span class="p">;</span>

    <span class="sd">/**</span>
<span class="sd">     * @Assert\NotBlank()</span>
<span class="sd">     * @Assert\MinLength(3)</span>
<span class="sd">     */</span>
    <span class="k">private</span> <span class="nv">$lastName</span><span class="p">;</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\NotBlank</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\MinLength</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">private</span> <span class="nv">$firstName</span><span class="p">;</span>

    <span class="k">private</span> <span class="nv">$lastName</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'firstName'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">NotBlank</span><span class="p">());</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'firstName'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">MinLength</span><span class="p">(</span><span class="mi">3</span><span class="p">));</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'lastName'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">NotBlank</span><span class="p">());</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'lastName'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">MinLength</span><span class="p">(</span><span class="mi">3</span><span class="p">));</span>
    <span class="p">}</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	</div>
	<div class="section" id="getters">
	  <span id="index-8"></span><h3>Getters<a class="headerlink" href="#getters" title="Permalink to this headline">¶</a></h3>
	  <p>Constraints can also be applied to the return value of a method. Symfony2
	    allows you to add a constraint to any public method whose name starts with
	    "get" or "is". In this guide, both of these types of methods are referred
	    to as "getters".</p>
	  <p>The benefit of this technique is that it allows you to validate your object
	    dynamically. Depending on the state of your object, the method may return
	    different values which are then validated.</p>
	  <p>The next listing shows you how to use the <a class="reference internal" href="../reference/constraints/True.html"><em>True</em></a>
	    constraint to validate whether a dynamically generated token is correct:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 148px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># Acme/BlogBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\BlogBundle\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">getters</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">tokenValid</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">True</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">message</span><span class="p-Indicator">:</span> <span class="s">"The</span><span class="nv"> </span><span class="s">token</span><span class="nv"> </span><span class="s">is</span><span class="nv"> </span><span class="s">invalid"</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- Acme/BlogBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\BlogBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;getter</span> <span class="na">property=</span><span class="s">"tokenValid"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"True"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;option</span> <span class="na">name=</span><span class="s">"message"</span><span class="nt">&gt;</span>The token is invalid<span class="nt">&lt;/option&gt;</span>
        <span class="nt">&lt;/constraint&gt;</span>
    <span class="nt">&lt;/getter&gt;</span>
<span class="nt">&lt;/class&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Assert\True(message = "The token is invalid")</span>
<span class="sd">     */</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">isTokenValid</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="c1">// return true or false</span>
    <span class="p">}</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\True</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addGetterConstraint</span><span class="p">(</span><span class="s1">'tokenValid'</span><span class="p">,</span> <span class="k">new</span> <span class="k">True</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
            <span class="s1">'message'</span> <span class="o">=&gt;</span> <span class="s1">'The token is invalid'</span><span class="p">,</span>
        <span class="p">)));</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">isTokenValid</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="c1">// return true or false</span>
    <span class="p">}</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>The public <tt class="docutils literal"><span class="pre">isTokenValid</span></tt> method will perform any logic to determine if
	    the internal token is valid and then return <tt class="docutils literal"><span class="pre">true</span></tt> or <tt class="docutils literal"><span class="pre">false</span></tt>.</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">The keen-eyed among you will have noticed that the prefix of the getter
		("get" or "is") is omitted in the mapping. This allows you to move the
		constraint to a property with the same name later (or vice versa) without
		changing your validation logic.</p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="final-thoughts">
	<h2>Final Thoughts<a class="headerlink" href="#final-thoughts" title="Permalink to this headline">¶</a></h2>
	<p>The Symfony2 <tt class="docutils literal"><span class="pre">validator</span></tt> is a powerful tool that can be leveraged to
	  guarantee that the data of any object is "valid". The power behind validation
	  lies in "constraints", which are rules that you can apply to properties or
	  getter methods of your object. And while you'll most commonly use the validation
	  framework indirectly when using forms, remember that it can be used anywhere
	  to validate any object.</p>
      </div>
      <div class="section" id="learn-more-from-the-cookbook">
	<h2>Learn more from the Cookbook<a class="headerlink" href="#learn-more-from-the-cookbook" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><a class="reference internal" href="../cookbook/validation/custom_constraint.html"><em>How to create a Custom Validation Constraint</em></a></li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Testing" href="testing.html">
      «&nbsp;Testing
    </a><span class="separator">|</span>
    <a accesskey="N" title="Forms" href="forms.html">
      Forms&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
