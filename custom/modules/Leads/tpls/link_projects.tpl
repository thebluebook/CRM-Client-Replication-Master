
{if $smarty.get.to_pdf neq '1'}


<div class="moduleTitle">
<h2>
	<a href="index.php?module=Leads&amp;action=index">
     <img align="absmiddle" title="Leads" alt="Leads" src="themes/SuiteP/images/icon_Leads_32.png?s=7ffb40711ab82f9fe5e580baf43ce4de&amp;c=1&amp;developerMode=1265611612"></a>
     <span class="pointer">»</span>Project Leads Deduping
</h2>
 <span class="utils"></span>
</div>
    <br clear="all"/> 


<form id="MassUpdate" action="" method="post" name="MassUpdate" id="MassUpdate" onsubmit="$('input[name=save_link_projects]').val('1');return linkAllSubmit();">
<input type="hidden" name="module" value="Leads" />
<input type="hidden" name="action" value="link_projects" />
<input type="hidden" name="uid" value="{$ST_ASSIGN_IDS}" />

<input type="hidden" id="save_link_projects" name="save_link_projects" value="" />
<div id="Leadsbasic_searchSearchForm" style="" class="">

            <table width="20%" >
                <tr>
                    <td width="10%" >
                        <input name="link_projects" {if $AR_DUP_LIST_DATA|count lte 0 } disabled {/if}  type='submit' class="button primary" value="{$APP.LBL_LINK_TO_PROJECT}" />
                    </td>
                    <td width="10%">
                        <input  type='button' class="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" onclick="window.location.href='index.php?module=Leads&action=index'" style="margin-left:6%;margin-top:4%;" />
                    </td>
                    <td width="80%"> &nbsp;</td>
                </tr>
            </table>
</div>


{/if}
<div id="container">
<br clear="all"/>
<div class="listViewBody"  >
	    <div class="edit ">&nbsp;</div>
        <table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view" >        
        
            {foreach name=lead_to_dupe from=$AR_DUP_LIST_DATA item=data}
            
            {if $smarty.foreach.lead_to_dupe.index eq 0}
            
             <tr class="pagination">
                    <td colspan="8">
                    </td>
                </tr>
                <tr height="20" style ="background-color: #ebebed; border-top: 1px solid #cccccc;border-bottom: 1px solid #cccccc; border-right: 1px solid #cccccc;border-left: 1px solid #cccccc;">
                    <th scope="col"  width="2%" class="selectCol">
                        <div>
                        {* sListView.check_all(document.masterList{$smarty.foreach.lead_to_dupe.index}, 'mass[]', this.checked); *}
                            <input type="checkbox"  name="massall" id="massall" value="" onclick="checkAll();">
                        </div>
                    </th>
                    <th scope="col" width="20%" >
                        <div style="white-space: nowrap;" width="100%" align="left">
                            <a href="javascript:void(0)" onclick="sortDupe('index.php?module=Leads&action=link_projects&sort=project_title&mass[]={$data->id}&odr={$order}&to_pdf=1')" class="listViewThLinkS1" style="color: #666;">
                                {$MOD.LBL_PROJECT_TITLE}
                            </a>&nbsp;&nbsp;
                           {if $smarty.request.sort eq 'project_title' and $smarty.request.odr eq 'ASC' }
                                {assign var=imageName value='arrow_up.gif'}
                            {elseif $smarty.request.sort eq 'project_title' and $smarty.request.odr eq 'DESC' }
                                {assign var=imageName value='arrow_down.gif'}
                            {else}
                            {assign var=imageName value='arrow.gif'}
                            {/if}
                            <img border="0" src="themes/default/images/{$imageName}" width="8" height="10" align="absmiddle" alt="Sort">

                        </div>
                    </th>
                    <th scope="col" width="15%" >
                        <div style="white-space: nowrap;" width="100%" align="left">
                            <a href="javascript:void(0)" onclick="sortDupe('index.php?module=Leads&action=link_projects&sort=lead_version&mass[]={$data->id}&odr={$order}&to_pdf=1')" class="listViewThLinkS1" style="color: #666;">
                                {$MOD.LBL_LEAD_VERSION}
                            </a>&nbsp;&nbsp;
                           {if $smarty.request.sort eq 'lead_version' and $smarty.request.odr eq 'ASC' }
                                {assign var=imageName value='arrow_up.gif'}
                            {elseif $smarty.request.sort eq 'lead_version' and $smarty.request.odr eq 'DESC' }
                                {assign var=imageName value='arrow_down.gif'}
                            {else}
                            {assign var=imageName value='arrow.gif'}
                            {/if}
                            <img border="0" src="themes/default/images/{$imageName}" width="8" height="10" align="absmiddle" alt="Sort">

                        </div>
                    </th>
                    <th scope="col" width="20%" >
                        <div style="white-space: nowrap;" width="100%" align="left">
                            <a href="javascript:void(0)" onclick="sortDupe('index.php?module=Leads&action=link_projects&sort=state&mass[]={$data->id}&odr={$order}&to_pdf=1')" class="listViewThLinkS1" style="color: #666;">
                                {$MOD.LBL_LOCATION}
                            </a>&nbsp;&nbsp;
                            {if $smarty.request.sort eq 'state' and $smarty.request.odr eq 'ASC' }
                                {assign var=imageName value='arrow_up.gif'}
                            {elseif $smarty.request.sort eq 'state' and $smarty.request.odr eq 'DESC' }
                                {assign var=imageName value='arrow_down.gif'}
                            {else}
                            {assign var=imageName value='arrow.gif'}
                            {/if}
                            <img border="0" src="themes/default/images/{$imageName}" width="8" height="10" align="absmiddle" alt="Sort">

                        </div>
                    </th>
                    <th scope="col" width="10%" >
                        <div style="white-space: nowrap;" width="100%" align="left">
                            <a href="javascript:void(0)" onclick="sortDupe('index.php?module=Leads&action=link_projects&sort=bids_due&mass[]={$data->id}&odr={$order}&to_pdf=1')" class="listViewThLinkS1" style="color: #666;">
                                {$MOD.LBL_BIDS_DUE}
                            </a>&nbsp;&nbsp;
                            {if $smarty.request.sort eq 'bids_due' and $smarty.request.odr eq 'ASC' }
                                {assign var=imageName value='arrow_up.gif'}
                            {elseif $smarty.request.sort eq 'bids_due' and $smarty.request.odr eq 'DESC' }
                                {assign var=imageName value='arrow_down.gif'}
                            {else}
                            {assign var=imageName value='arrow.gif'}
                            {/if}
                            <img border="0" src="themes/default/images/{$imageName}" width="8" height="10" align="absmiddle" alt="Sort">

                        </div>
                    </th>
                    <th scope="col" width="10%" >
                        <div style="white-space: nowrap;" width="100%" align="left">
                            <a href="javascript:void(0)" onclick="sortDupe('index.php?module=Leads&action=link_projects&sort=pre_bid_meeting&mass[]={$data->id}&odr={$order}&to_pdf=1')" class="listViewThLinkS1" style="color: #666;">
                               {$MOD.LBL_PRE_BID_MEETING}
                            </a>&nbsp;&nbsp;

                            {if $smarty.request.sort eq 'pre_bid_meeting' and $smarty.request.odr eq 'ASC' }
                                {assign var=imageName value='arrow_up.gif'}
                            {elseif $smarty.request.sort eq 'pre_bid_meeting' and $smarty.request.odr eq 'DESC' }
                                {assign var=imageName value='arrow_down.gif'}
                            {else}
                            {assign var=imageName value='arrow.gif'}
                            {/if}
                            <img border="0" src="themes/default/images/{$imageName}" width="8" height="10" align="absmiddle" alt="Sort">
                        </div>
                    </th>
                    <th scope="col"  width="10%" style="color: #666;">Plans</th>
                    <th scope="col"  width="10%" style="color: #666;">{$MOD.LBL_CONTACT_NO}</th>
                </tr>

                <tr height="20" class="oddListRowS1">
                    <td scope="col"  width="2%" class="">

                    </td>
                    <td scope="col" width="25%" >
                        {$data->project_title}
                    </td>
                    <td scope="col" width="15%"  align="center" >
                        <div style="white-space: text-align:center;" width="100%" align="center">
                        {$data->fetched_row.lead_version}
                        </div>
                    </td>
                    <td scope="col" width="15%" >

                        {assign var=state_name value=$data->state}

                    {$data->city} {if $data->state neq ''},{/if} {$STATE_DOM.$state_name}
                    </td>
                    <td scope="col" width="10%" >                                                              
                         {$timedate->to_display_date($data->bids_due_tz, false)}                  
                         
                    </td>
                    <td scope="col" width="10%" >
                        {$timedate->to_display_date($data->fetched_row.pre_bid_meeting)}

                    </td>
                    <td scope="col"  width="10%">
					
                    
                       {if $data->fetched_row.lead_plans neq '0' && $data->fetched_row.lead_plans neq ''} <div id="url{$data->id}" style="position: absolute; z-index: 1000; background-image: none;   visibility: visible;"></div>
                        <a style="font-weight:normal;color: #006BB9" href="javascript:void(0)"  onclick="javascript:open_urls('{$data->id}')" >View</a>{/if}
                       
                        </td>
                    <td scope="col"  width="10%">{$data->contact_no}</td>
                </tr>
            
            {else}
            
            
            
              
 			<tr height="20" class="oddListRowS1">
                    <td  class="nowrap">
                        <input  type="checkbox" class="checkbox" name="mass[{$AR_DUP_LIST_DATA[0]->id}][]" value="{$data->id}"/>
                    </td>
                    <td scope="row" align="left" valign="top" class="">
                        <!-- <a href="index.php?module=Leads&action=DetailView&record={$data->id}" onmouseover="javascript:lvg_nav('Leads', '{$data->id}', 'd', 1, this)" onfocus="javascript:lvg_nav('Leads', '{$data->id}', 'd', 1, this)"> -->
                       <a href="javascript:void(0);" onClick = "compareLeads('{$data->id}','{$AR_DUP_LIST_DATA[0]->id}')">
                 	   {$data->project_title}
                        </a>
                    </td>
                    <td scope="row" align="center" valign="top" class="">                        
                            {$data->fetched_row.lead_version}                        
                    </td>
                    <td scope="row" align="left" valign="top" class="">       

                        {assign var=state_name value=$data->state}

                     {$data->city} {if $data->state neq ''},{/if} {$STATE_DOM.$state_name}


                    </td>
                    <td scope="row" align="left" valign="top" class="">
                        {$timedate->to_display_date($data->fetched_row.bids_due_tz, false)}

                    </td>
                    <td scope="row" align="left" valign="top" class="">
                        {$timedate->to_display_date($data->pre_bid_meeting)}

                    </td>
                    <td align="left" class="helpIcon" width="*">				
                       
						{if $data->lead_plans neq '' and $data->lead_plans > 0  }  <div id="url{$data->id}" style="position: absolute; z-index: 1000; background-image: none;   visibility: visible;"></div>
                        <a href="javascript:void(0)"  onclick="javascript:open_urls('{$data->id}')" >View</a>
                      {/if}                   
                        
                    </td>
					<td></td>
                    <td align="left">
                    {$data->contact_no}
                    </td>
                </tr>       
                
                {/if}
        
        {/foreach}
            
        </table>
        
        </div>
     </div>       
{if $smarty.get.to_pdf neq '1'}
&nbsp;
       <div id="Leadsbasic_searchSearchForm" style="" class="">

            <table width="20%" >
                <tr>
                    <td width="10%" >
                        <input name="link_projects" {if $AR_DUP_LIST_DATA|count lte 0 } disabled {/if}  type='submit' class="button primary" value="{$APP.LBL_LINK_TO_PROJECT}" >
                    </td>
                    <td width="10%">
                        <input  type='button' class="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" onclick="window.location.href='index.php?module=Leads&action=index'" style="margin-left:6%;margin-top:4%;" />
                    </td>
                    <td width="80%"> &nbsp;</td>
                </tr>
            </table>
</div>
        <script src="{sugar_getjspath file='cache/include/javascript/sugar_grp_overlib.js'}" type="text/javascript"></script>
        <div style="width:100px;position: absolute; visibility: hidden; z-index: 1000; left: 525px; top: 0px; background-image: none;" id="overDiv">
    </form>

   
{literal}
<script type='text/javascript' src="include/javascript/overlibmws.js"></script>
    <script type="text/javascript">
        function linkAllSubmit(){
        $('input[name^=mass]:not(input[name^=massall])').length
             elm = YAHOO.util.Selector.query('input[name^=mass]:not(input[name^=massall]):checked')
            if(elm.length >0)
            {
                if(showModel('{/literal}{$APP.MSG_LINK_TO_PROJECT_CONFIRM}{literal}','Confirm Dedupe'))
                {
                	//$('input[name=save_link_projects]').val('1');
                	document.getElementById('save_link_projects').value= '1'
                	return true;
                    
                }
                
            }else{
            	
                alert('{/literal}{$APP.LBL_LISTVIEW_NO_SELECTED}{literal}')
                
                
            }
            return false;
        }

        function open_urls(plid){

            
 ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_LOADING'));
            cont = document.getElementById('url'+plid);
                
            if(cont.innerHTML != '')
            {
                all = YAHOO.util.Selector.query('div[id^=url]');
                for( i in all){
                    all[i].style.display='none';
                }
                cont.style.display = '';
                
            }else{
            
            var sUrl = "index.php?module=Leads&action=projecturl&record="+plid+"&to_pdf=true&mine=1";
            var callback = {
                
                    success: function(o) {
                    //SUCCESS
                    //document.getElementById('url'+plid).innerHTML = o.responseText;
oReturn = function(body, caption, width, theme) {
                                        $(".ui-dialog").find(".opOpen").dialog("close");
                                        var bidDialog = $('<div class="opOpen"></div>')
                                        .html(body)
                                        .dialog({
              					model:true,
                                                autoOpen: false,
                                                title: caption,
                                                width: width,
       					//	height : height,
              				//show: "slide",
              				//hide: "scale",                                                
                                        });
                                        bidDialog.dialog('open');

                                };
       
oReturn(o.responseText,"URL Details", '555px', '');                    




/*                        overlib(
o.responseText
, STICKY
, MOUSEOFF
,1000
,WIDTH
, 400
, LEFT
,CAPTION
,'<div style="float:left">URL Details</div>'
, CLOSETEXT
, '<div style=\'float: right\'><img border=0 style=\'margin-left:2px; margin-right: 2px;\' src=themes/Sugar/images/close.png?s=7ffb40711ab82f9fe5e580baf43ce4de&amp;c=1&amp;developerMode=896855794></div>'
,CLOSETITLE
, SUGAR.language.get('app_strings', 'LBL_SEARCH_HELP_CLOSE_TOOLTIP')
, CLOSECLICK
,FGCLASS
, 'olFgClass'
, CGCLASS
, 'olCgClass'
, BGCLASS
, 'olBgClass'
, TEXTFONTCLASS
, 'olFontClass'
, CAPTIONFONTCLASS
, 'olCapFontClass');

*/
ajaxStatus.hideStatus();
                },
                    failure: function(o) {
                   // alert("AJAX doesn't work"); //FAILURE
                    }
                }

                var transaction = YAHOO.util.Connect.asyncRequest('GET', sUrl, callback, null);
            }
        }

        function showModel(htmltext,titleVal){

        	if(typeof(dialog) != 'undefined')
        	{
        		dialog.destroy();
            }
        			dialog = new YAHOO.widget.Dialog('details_popup_div', {
                    	width: '500px',	
            						
                    		fixedcenter : "contained",    				
                    		visible : true, 
                    		draggable: true,
                    		modal:true,
                    		/*effect:[{effect:YAHOO.widget.ContainerEffect.SLIDE, duration:0.2},        
                    				{effect:YAHOO.widget.ContainerEffect.FADE,duration:0.2}],
        					  */       modal:true
        					         
        					         });
        				dialog.setHeader(titleVal);
        				dialog.setBody(htmltext);
        				dialog.setFooter('');

        				var handleCancel = function() {
					
            				this.cancel();
            				
        				};
        				var handleSubmit = function() {
        					document.getElementById('MassUpdate').submit();
                  			this.cancel();
              			//return false;
        				};
        				var myButtons = [{ text: "Continue", handler: handleSubmit, isDefault: true }
        								 ,{ text: "Cancel", handler: handleCancel, isDefault: false }
        								 ];
        				dialog.cfg.queueProperty("buttons", myButtons);
        				dialog.render(document.body);
        				dialog.show();
            			//dialog.configFixedCenter(null,false)
        	           
        	}

    	
       /*
       	* Functions to show Lead comparison
       	*/ 
       function DetailsDialog(div_id, text) {
            this.div_id = div_id;
            this.text = text;
            this.width = "800px";
            this.header = '';
            this.footer = '';
        }
        
        function header(header) {
            this.header = header;
        }

        function footer(footer) {
            this.footer = footer;
        }

        function display() {
            dialog = new YAHOO.widget.Dialog(this.div_id, {
	            width: this.width,
	            height: "",
	            fixedcenter : "contained",
				visible : true, 
				draggable: true,
	            modal:true,
         	});
            var myButtons = [
                             { text: "Link to Project", handler: handleSubmit, isDefault: true },
                             { text: "Cancel", handler: handleCancel }
                         ];
           	dialog.cfg.queueProperty("buttons", myButtons);
            dialog.setHeader(this.header);
            dialog.setBody(this.text);
            dialog.setFooter(this.footer);
            dialog.render(document.body);
            dialog.show();
           
        }
        DetailsDialog.prototype.setHeader = header;
        DetailsDialog.prototype.setFooter = footer;
        DetailsDialog.prototype.display = display; 

        var handleCancel = function() {
            this.cancel();
        };
        var handleSubmit = function() {
        	  var e= document.MassUpdate.elements.length;
        	  var cnt=0;
        	  var pdld = document.getElementById('pdld').value;
        	  for(cnt=0;cnt<e;cnt++)
        	  {
        	    if(document.MassUpdate.elements[cnt].value==pdld){
        	    	document.MassUpdate.elements[cnt].checked = true;
        	    }
        	  }
        	  this.cancel();
        };
        
        function compareLeads(lead,compareLead){

			var record = compareLead;
        	
            var isIE = document.all?true:false;
            
            if(document.getElementById('details_popup_div_c'))
            {
                 document.getElementsByTagName('body')[0].removeChild(document.getElementById('details_popup_div_c'));	
            }
            if(lead == '')
                return false;

            ac = new DetailsDialog("details_popup_div", '<div id="details_div"></div>');
            ac.setHeader('<table width="100%"><tr><td align="left" width="600">Original Project</td><td align="left"  width="400">Potential Duplicate</th></tr></table>');
            ac.display();

            var callback = {
                       cache:false,
                       success: function(o) {
                       res = o.responseText;
                       document.getElementById('details_div').innerHTML = res;
                       SUGAR.util.evalScript(o.responseText);
                   }
            }

            document.getElementById('details_div').innerHTML = 'Loading...';

            YAHOO.util.Connect.asyncRequest('GET', 'index.php?to_pdf=true&module=Leads&action=comparelead&lead='+lead+'&record='+record,callback);

      }
      
      
      function sortDupe(urlSort){
			
		
		//window.loacation.href =urlSort; 
		var a = urlSort.split("&mass[]=");
		var aId = a[1].split("&")
		
		$.ajax( {url:urlSort
				 ,type :"post"
				 ,data: "uid="+$('input[name=uid]').val()+'&primary_lead='+aId[0]
				 ,beforeSend:function(){
				 	$('#container div.edit').attr('style','padding:1px;text-align:center;font-weight:bold')
				 	$('#container div.edit').html('Loading..')
				 }				 	
				 ,error:function(data){
				 		
				 	}
				 ,complete:function (data){
				 		console.log(data)
				 		
		
						//console.log('#container')
				 		$('#container').html(data.responseText)
				 		
				 	}				 
				})
		
		}
		
	function checkAll () {
		if($('#massall').prop('checked')){
			$('#container .checkbox').each(
				function(i,elm){
					$('#container .checkbox').prop('checked',true);
				}
			);
		} else {
			$('#container .checkbox').each(
				function(i,elm){
					$('#container .checkbox').prop('checked',false);
				}
			);
		}
	}
		
    </script>

{/literal}

{/if}