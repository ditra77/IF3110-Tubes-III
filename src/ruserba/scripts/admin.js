function hapusKategori(){
    //if(document.getElementById('id').checked == true){
     //   alert('tes')
        return confirm('Apakah anda ingin menghapus kategori?');
    //} else{
      //  return false;
    //}
}


function hapusBarang(){
    //if(document.getElementById('id').checked == true){
     //   alert('tes')
        return confirm('Apakah anda ingin menghapus barang?');
    //} else{
      //  return false;
    //}
}

function tambahKategori(){
   if(document.getElementById('idnama').value.length==0){
      alert("Nama tidak boleh kosong")
      return false;
   } else{      
      return true;
   }
}

function tambahBarang(){
    if(document.getElementById('idnama').value.length==0){
       alert("Nama tidak boleh kosong") 
       return false;
    }else{      
        if(document.getElementById('idharga').value.length==0){
            alert("Harga tidak boleh kosong") 
            return false;
        } else {
            if(document.getElementById('idtersedia').value.length==0){
                alert("Tersedia tidak boleh kosong") 
                return false;
            } else{
                var filename=document.getElementById('idgambar').value;
                var re = /\..+$/;
                var ext = filename.match(re);
                if(!(ext==".jpg")){
                    alert("Ekstensi file tidak diterima");
                    return false;
                }else{
                    return true;
                }
            }
        }
    }
}
