<?php include(__DIR__.'/../../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">datetime Field Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="datetime-field-type">
      <span id="index-0"></span><h1>datetime Field Type<a class="headerlink" href="#datetime-field-type" title="Permalink to this headline">¶</a></h1>
      <p>This field type allows the user to modify data that represents a specific
	date and time (e.g. <tt class="docutils literal"><span class="pre">1984-06-05</span> <span class="pre">12:15:30</span></tt>).</p>
      <p>Can be rendered as a text input or select tags. The underlying format of the
	data can be a <tt class="docutils literal"><span class="pre">DateTime</span></tt> object, a string, a timestamp or an array.</p>
      <table border="1" class="docutils">
	<colgroup>
	  <col width="22%">
	  <col width="78%">
	</colgroup>
	<tbody valign="top">
	  <tr><td>Underlying Data Type</td>
	    <td>can be <tt class="docutils literal"><span class="pre">DateTime</span></tt>, string, timestamp, or array (see the <tt class="docutils literal"><span class="pre">input</span></tt> option)</td>
	  </tr>
	  <tr><td>Rendered as</td>
	    <td>single text box or three select fields</td>
	  </tr>
	  <tr><td>Options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">date_widget</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">time_widget</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">input</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">years</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">months</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">days</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">format</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">pattern</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">data_timezone</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">user_timezone</span></tt></li>
	      </ul>
	    </td>
	  </tr>
	  <tr><td>Parent type</td>
	    <td><a class="reference internal" href="form.html"><em>form</em></a></td>
	  </tr>
	  <tr><td>Class</td>
	    <td><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Form/Extension/Core/Type/DatetimeType.html" title="Symfony\Component\Form\Extension\Core\Type\DatetimeType"><span class="pre">DatetimeType</span></a></tt></td>
	  </tr>
	</tbody>
      </table>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">date_widget</span></tt> [type: string, default: choice]</dt>
	      <dd><p class="first last">Defines the <tt class="docutils literal"><span class="pre">widget</span></tt> option for the <a class="reference internal" href="date.html"><em>date</em></a> type</p>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">time_widget</span></tt> [type: string, default: choice]</dt>
	      <dd><p class="first last">Defines the <tt class="docutils literal"><span class="pre">widget</span></tt> option for the <a class="reference internal" href="time.html"><em>time</em></a> type</p>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">input</span></tt> [type: string, default: <tt class="docutils literal"><span class="pre">datetime</span></tt>]</dt>
	      <dd><p class="first">The value of the input for the widget.  Can be <tt class="docutils literal"><span class="pre">string</span></tt>, <tt class="docutils literal"><span class="pre">datetime</span></tt>
		  or <tt class="docutils literal"><span class="pre">array</span></tt>.  The form type input value will be returned in the format
		  specified.  The input of <tt class="docutils literal"><span class="pre">April</span> <span class="pre">21th,</span> <span class="pre">2011</span> <span class="pre">18:15:30</span></tt> as an array would return:</p>
		<div class="last highlight-php"><div class="highlight"><pre><span class="k">array</span><span class="p">(</span><span class="s1">'month'</span> <span class="o">=&gt;</span> <span class="mi">4</span><span class="p">,</span> <span class="s1">'day'</span> <span class="o">=&gt;</span> <span class="mi">21</span><span class="p">,</span> <span class="s1">'year'</span> <span class="o">=&gt;</span> <span class="mi">2011</span><span class="p">,</span> <span class="s1">'hour'</span> <span class="o">=&gt;</span> <span class="mi">18</span><span class="p">,</span> <span class="s1">'minute'</span> <span class="o">=&gt;</span> <span class="mi">15</span><span class="p">,</span> <span class="s1">'second'</span> <span class="o">=&gt;</span> <span class="mi">30</span><span class="p">)</span>
		  </pre></div>
		</div>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">years</span></tt> [type: array, default: five years before to five years after the current year ]</dt>
	      <dd><p class="first last">List of years available to the year field type.  This option is only
		  relevant when the <tt class="docutils literal"><span class="pre">widget</span></tt> option is set to <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">months</span></tt> [type: array, default: 1 to 12 ]</dt>
	      <dd><p class="first last">List of months available to the month field type. This option is only relevant when the <tt class="docutils literal"><span class="pre">widget</span></tt> option is set to <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">days</span></tt> [type: array, default: 1 to 31 ]</dt>
	      <dd><p class="first">List of days available to the day field type.  This option is only relevant when the <tt class="docutils literal"><span class="pre">widget</span></tt> option is set to <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
		<div class="last highlight-php"><div class="highlight"><pre><span class="s1">'days'</span> <span class="o">=&gt;</span> <span class="nb">range</span><span class="p">(</span><span class="mi">1</span><span class="p">,</span><span class="mi">31</span><span class="p">)</span>
		  </pre></div>
		</div>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">hours</span></tt> [type: integer, default: 1 to 23 ]</dt>
	      <dd><p class="first last">List of hours available to the hours field type.  This option is only relevant when the <tt class="docutils literal"><span class="pre">widget</span></tt> option is set to <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">minutes</span></tt> [type: integer, default: 1 to 59 ]</dt>
	      <dd><p class="first last">List of minutes available to the minutes field type.  This option is only relevant when the <tt class="docutils literal"><span class="pre">widget</span></tt> option is set to <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">seconds</span></tt> [type: integer, default: 1 to 59 ]</dt>
	      <dd><p class="first last">List of seconds available to the seconds field type.  This option is only relevant when the <tt class="docutils literal"><span class="pre">widget</span></tt> option is set to <tt class="docutils literal"><span class="pre">choice</span></tt>.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">with_seconds</span></tt> [type: Boolean, default: false]</dt>
	      <dd><p class="first last">Whether or not to include seconds in the input. This will result in an additional input to capture seconds.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">data_timezone</span></tt> [type: string, default: system default timezone]</dt>
	      <dd><p class="first last">Timezone for the data being stored.  This must be one of the <a class="reference external" href="http://php.net/manual/en/timezones.php">PHP supported timezones</a></p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">user_timezone</span></tt> [type: string, default: system default timezone]</dt>
	      <dd><p class="first last">Timezone for the data being submitted by the user.  This must be one of the <a class="reference external" href="http://php.net/manual/en/timezones.php">PHP supported timezones</a></p>
	      </dd>
	    </dl>
	  </li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="date Field Type" href="date.html">
      «&nbsp;date Field Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="email Field Type" href="email.html">
      email Field Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
