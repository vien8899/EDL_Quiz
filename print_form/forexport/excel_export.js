async function export_data(_param){
    var url = "assets/files/report_excel.xlsx";
    var oReq = new XMLHttpRequest();

    oReq.open("GET", url, true);
    oReq.responseType = "arraybuffer";
    console.log(_param);
    oReq.onload = async function(e) {
          
          var arraybuffer = oReq.response;
          /* convert data to binary string */
          var data = new Uint8Array(arraybuffer);
          var arr = new Array();
          for(var i = 0; i != data.length; ++i) arr[i] = String.fromCharCode(data[i]);
          var bstr = arr.join("");

          /* Call XLSX */
          let workbook = XLSX.read(bstr, {type:"binary"});
          let worksheet = workbook.Sheets[workbook.SheetNames[0]];
          let border ={
            top:{style:'thin',color:{rgb:'000000'}},
            bottom:{style:'thin',color:{rgb:'000000'}},
            left:{style:'thin',color:{rgb:'000000'}},
            right:{style:'thin',color:{rgb:'000000'}},
          }
          let center = {
              vertical:"center",
              wrapText:true,
              horizontal:"center"
          }
          
          let style = {font: { name: 'Phetsarath OT'},border:border};  
          let font = {
            name: 'Phetsarath OT',
            sz:'12',
          }
          let h_style = {
              font: { 
                  name: 'Phetsarath OT',
                  sz:'12', 
                  bold:true,
                  color: { r: 139, g: 0, b: 0 } 
              },
              alignment:center,
              border:border
          }
        let des = 'ສູນຝຶກອົບຮົມ, ຝ່າຍຈັດຕັ້ງ ແລະ ບໍລິຫານ ຂໍຖືເປັນກຽດ '+title_des.value+' ດັ່ງລາຍລະອຽດລຸ່ມນີ້:';
        worksheet['A2'].s={font:font,alignment:{horizontal:"center"}};
        worksheet['A3'].s={font:font,alignment:{horizontal:"center"}};
        worksheet['A4'].s = {font:font,alignment:{horizontal:"left"}};
        worksheet['A5'].s = {font:font,alignment:{horizontal:"left"}};
        worksheet['A6'].s = {font:font,alignment:{horizontal:"left"}};
        worksheet['F5'].s = {font:font,alignment:{horizontal:"right"}};
        worksheet['F6'].s = {font:font,alignment:{horizontal:"right"}};
        worksheet['A7'].s = {font:{name:'Phetsarath OT',sz:'16'},alignment:{horizontal:"center"}};
        worksheet['B8'].s = {font:font,alignment:{horizontal:"left"}};
        worksheet['B9'].s = {font:font,alignment:{horizontal:"left"}};
        worksheet['B9'].v = des;
        worksheet['A10'].s = h_style;
        worksheet['B10'].s = h_style;
        worksheet['C10'].s = h_style;
        worksheet['D10'].s = h_style;
        worksheet['E10'].s = h_style;
        worksheet['F10'].s = h_style;
        worksheet['G10'].s = h_style;
        worksheet['H10'].s = h_style;
        worksheet['I10'].s = h_style;
        if(_param.length>0){
            _param.forEach((item,index)=>{
                worksheet['A'+(index+11)]={v:String(index+1),s: {font: { name: 'Phetsarath OT'},alignment:center,border:border}};
                worksheet['B'+(index+11)]={v:String(item.user_code),s:style};
                worksheet['C'+(index+11)]={v:String(item.fullname),s:style};
                worksheet['D'+(index+11)]={v:String(item.degree),s:style};
                worksheet['E'+(index+11)]={v:String(item.technical_knowledge),s:style};
                worksheet['F'+(index+11)]={v:String(item.unit_des),s:style};
                worksheet['G'+(index+11)]={v:String(item.dep_name),s:style};
                worksheet['H'+(index+11)]={v:String(item.point),s:style};
                worksheet['I'+(index+11)]={v:String(item.remark),s:style};
            });
        }
        var wopts = { bookType:'xlsx', bookSST:true, type:'binary' };
        var wbout = XLSX.write(workbook,wopts);
        let today = new Date();
        let filename = "report_data"+today.getFullYear()+today.getMonth()+today.getDate()+today.getHours()+today.getMinutes()+".xlsx";
        saveAs(new Blob([s2ab(wbout)],{type:""}), filename);
        // console.log(worksheet);

    }
    oReq.send();
}
function s2ab(s) {
    var buf = new ArrayBuffer(s.length);
    var view = new Uint8Array(buf);
    for (var i=0; i!=s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
    return buf;
}

function decode( text ) {
    return text
        .replaceAll( "#amp;",'&' )
        .replaceAll( "#quot;",'"' )
        .replaceAll( "#plus;",'+' )
        .replaceAll( "#039;","'" )
}
function encode( text ) {
    return text
        .replace( /&/g, "#amp;" )
        .replace( /"/g, "#quot;" )
        .replace( /\+/g, "#plus;" )
        .replace( /'/g, "#039;" );
}