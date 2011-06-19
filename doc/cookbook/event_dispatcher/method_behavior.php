<?php include(__DIR__.'/../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">How to customize a Method Behavior without using Inheritance</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="how-to-customize-a-method-behavior-without-using-inheritance">
      <span id="index-0"></span><h1>How to customize a Method Behavior without using Inheritance<a class="headerlink" href="#how-to-customize-a-method-behavior-without-using-inheritance" title="Permalink to this headline">¶</a></h1>
      <div class="section" id="doing-something-before-or-after-a-method-call">
	<h2>Doing something before or after a Method Call<a class="headerlink" href="#doing-something-before-or-after-a-method-call" title="Permalink to this headline">¶</a></h2>
	<p>If you want to do something just before, or just after a method is called, you
	  can dispatch an event respectively at the beginning or at the end of the
	  method:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">class</span> <span class="nc">Foo</span>
<span class="p">{</span>
    <span class="c1">// ...</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">send</span><span class="p">(</span><span class="nv">$foo</span><span class="p">,</span> <span class="nv">$bar</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="c1">// do something before the method</span>
        <span class="nv">$event</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">FilterBeforeSendEvent</span><span class="p">(</span><span class="nv">$foo</span><span class="p">,</span> <span class="nv">$bar</span><span class="p">);</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">dispatcher</span><span class="o">-&gt;</span><span class="na">dispatch</span><span class="p">(</span><span class="s1">'foo.pre_send'</span><span class="p">,</span> <span class="nv">$event</span><span class="p">);</span>

        <span class="c1">// get $foo and $bar from the event, they may have been modified</span>
        <span class="nv">$foo</span> <span class="o">=</span> <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">getFoo</span><span class="p">();</span>
        <span class="nv">$bar</span> <span class="o">=</span> <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">getBar</span><span class="p">();</span>
        <span class="c1">// the real method implementation is here</span>
        <span class="c1">// $ret = ...;</span>

        <span class="c1">// do something after the method</span>
        <span class="nv">$event</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">FilterSendReturnValue</span><span class="p">(</span><span class="nv">$ret</span><span class="p">);</span>
        <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">dispatcher</span><span class="o">-&gt;</span><span class="na">dispatch</span><span class="p">(</span><span class="s1">'foo.post_send'</span><span class="p">,</span> <span class="nv">$event</span><span class="p">);</span>

        <span class="k">return</span> <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">getReturnValue</span><span class="p">();</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>In this example, two events are thrown: <tt class="docutils literal"><span class="pre">foo.pre_send</span></tt>, before the method is
	  executed, and <tt class="docutils literal"><span class="pre">foo.post_send</span></tt> after the method is executed. Each uses a
	  custom Event class to communicate information to the listeners of the two
	  events. These event classes would need to be created by you and should allow,
	  in this example, the variables <tt class="docutils literal"><span class="pre">$foo</span></tt>, <tt class="docutils literal"><span class="pre">$bar</span></tt> and <tt class="docutils literal"><span class="pre">$ret</span></tt> to be retrieved
	  and set by the listeners.</p>
	<p>For example, assuming the <tt class="docutils literal"><span class="pre">FilterSendReturnValue</span></tt> has a <tt class="docutils literal"><span class="pre">setReturnValue</span></tt>
	  method, one listener might look like this:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">onFooPostSend</span><span class="p">(</span><span class="nx">FilterSendReturnValue</span> <span class="nv">$event</span><span class="p">)</span>
<span class="p">{</span>
    <span class="nv">$ret</span> <span class="o">=</span> <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">getReturnValue</span><span class="p">();</span>
    <span class="c1">// modify the original ``$ret`` value</span>

    <span class="nv">$event</span><span class="o">-&gt;</span><span class="na">setReturnValue</span><span class="p">(</span><span class="nv">$ret</span><span class="p">);</span>
<span class="p">}</span>
	  </pre></div>
	</div>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="How to extend a Class without using Inheritance" href="class_extension.html">
      «&nbsp;How to extend a Class without using Inheritance
    </a><span class="separator">|</span>
    <a accesskey="N" title="How to register a new Request Format and Mime Type" href="../request/mime_type.html">
      How to register a new Request Format and Mime Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
