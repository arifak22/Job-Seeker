import 'package:flutter/material.dart';
import 'package:http_query_string/http_query_string.dart';
import 'package:intl/intl.dart';
import 'package:line_awesome_flutter/line_awesome_flutter.dart';
import 'package:mobile/helpers/content_bar.dart';
import 'package:mobile/helpers/services.dart';
import 'package:mobile/helpers/widget.dart';
import 'package:mobile/pages/home/perusahaan_d_screen.dart';

class LokerDScreen extends StatefulWidget {
  dynamic data;
  @override

  LokerDScreen({Key? key, required this.data}) : super(key: key);
  _LokerDScreenState createState() => _LokerDScreenState();
}


class _LokerDScreenState extends State<LokerDScreen> {
    bool    _isLoading   = true;
    dynamic detil        = [];
    dynamic id_privilege = 0;
    bool    _postLoading = false;

    postLamar() async{
      setState(() {
        _postLoading = true;
      });
      var data = {
        'id' : widget.data['id'].toString(),
      };
       Services().postApi('lamar', data).then((val) async {
        if (val['api_status'] == 1) {
          setState(() {
            _postLoading = false;
          });
          print('sukses');
          showDialog(context: context, builder: (_) =>AlertDialog(
            title: Text('Berhasil'),
            content: Text('${val['api_message']}'),
            actions: <Widget>[ElevatedButton(onPressed: ()=>Navigator.pop(context), child: Text('Ok'))],
          ));
        }else{
          setState(() {
            _postLoading = false;
          });
          showDialog(context: context, builder: (_) =>AlertDialog(
            title: Text('Something wrong'),
            content: Text(val['api_message']),
            actions: <Widget>[ElevatedButton(onPressed: ()=>{Navigator.pop(context)}, child: Text('Ok'))],
          ));
        }
       });
    }
    getData() async{
      if(!mounted) return;
      var priv = await Services().getUser('id_privilege');
      setState(() {
        id_privilege = priv;
      });
      var parameters = Encoder().convert(<String, dynamic>{
        'id': widget.data['id'],
      });

      setState(() {
        _isLoading = true;
      });
      await Services().getApi('loker-detil', parameters).then((value) {
          if(value['api_status'] == 1){
            // print(value['deskripsi']);
            setState(() {
                detil = value;
                _isLoading = false;
            });
          }else{
            setState(() {
              detil = [];
              _isLoading = false;
            });
          }
      }
    );
  }
    
  @override
  void initState() {
    super.initState();
    getData();
  }
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        body:Container(
          width: double.infinity,
          height: double.infinity,
          decoration: BoxDecoration(
            gradient: LinearGradient(
              begin: Alignment.topRight,
                end: Alignment.topLeft,
                colors: <Color>[
                Color.fromARGB(255,12,62,148),
                Color.fromARGB(255,38,123,204),
              ]
            )
          ),
          // color: Color.fromARGB(255,39,82,159),
          child: Column(
            children: [
              Container(
                margin: EdgeInsets.only(top: 50, left: 15, right: 15),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    InkWell(child: Icon(LineAwesomeIcons.angle_left, color: Colors.white, size: 22), onTap: (){Navigator.pop(context);},),
                    Text('Detil Loker', style: TextStyle(fontSize: 22, fontWeight: FontWeight.w500, color: Colors.white),),
                    Icon(LineAwesomeIcons.info, color: Color.fromARGB(0, 1, 1, 1))
                  ],
                )
              ),
              Expanded(
                flex: 1,
                child: SingleChildScrollView(
                  child: Column(
                    children: [
                      Container(
                        margin: EdgeInsets.only(top: 20),
                        child: Column(
                          children: [
                            RoundImage(
                              width: 60,
                              height: 60,
                              image: NetworkImage(localStorage(widget.data['foto_perusahaan']))
                            ),
                            SizedBox(height: 10), 
                            Text(widget.data['judul'], textAlign: TextAlign.center, style: TextStyle(color: Colors.white, fontSize: 20, fontWeight: FontWeight.w600),),
                            SizedBox(height: 10), 
                            Row(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                Icon(LineAwesomeIcons.map_marker, size: 18, color: Colors.white),
                                Text(" ${widget.data['kecamatan']}, ${widget.data['kelurahan']}", style: TextStyle(fontSize: 13, color: Colors.white, fontWeight: FontWeight.w600),)
                              ],
                            ),
                            SizedBox(height: 10),
                            id_privilege == 1 ?
                            SizedBox(
                              width: 200,
                              child: ElevatedButton(
                                style: ButtonStyle(
                                  elevation: MaterialStateProperty.all<double>(0),
                                  backgroundColor: MaterialStateProperty.all<Color>(Color.fromARGB(255, 14,164,204)),
                                ),
                                onPressed: (){
                                  !_postLoading ? postLamar() : null;
                                }, 
                                child: Row(
                                  mainAxisAlignment: MainAxisAlignment.center,
                                  children:[
                                    Icon(LineAwesomeIcons.mail_bulk),
                                    Text(!_postLoading ? '  Lamar Pekerjaan' : 'Proses ....')
                                ])
                              ),
                            ) : Container(),
                            Container(
                              margin: EdgeInsets.only(top: 15, right: 20, left:20),
                              alignment: Alignment.center,
                              padding: EdgeInsets.symmetric(vertical: 15),
                              decoration: BoxDecoration(
                                borderRadius: BorderRadius.all(Radius.circular(20)),
                              // color: Color.fromARGB(255, 243, 240, 240)
                                color: Color.fromARGB(255, 240,243,244),
                              ),
                              child: 
                              Column(
                                children: [
                                  Row(
                                    children: [
                                      Container(
                                        padding: EdgeInsets.symmetric(horizontal: 15),
                                        child: Column(
                                          mainAxisAlignment: MainAxisAlignment.start,
                                          crossAxisAlignment: CrossAxisAlignment.start,
                                          children: [
                                            Padding(
                                              padding: const EdgeInsets.only(bottom: 5),
                                              child: Text('Batas Lamaran', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 14, color: Color.fromARGB(255, 90, 91, 103)),),
                                            ),
                                            Text( DateFormat('d MMMM y', 'id_ID').format(DateTime.parse(widget.data['tanggal_kadaluarsa'])), style: TextStyle(fontWeight: FontWeight.w600, color: Colors.blue),),
                                          ],
                                        ),
                                      ),
                                      // Divider(
                                      //   color: Colors.black
                                      // ),
                                      Container(
                                        color:  Color.fromARGB(255, 197, 198, 198),
                                        height: 50,
                                        width: 1,
                                      ),
                                      Container(
                                        padding: EdgeInsets.symmetric(horizontal: 15),
                                        child: Column(
                                          mainAxisAlignment: MainAxisAlignment.start,
                                          crossAxisAlignment: CrossAxisAlignment.start,
                                          children: [
                                            Padding(
                                              padding: const EdgeInsets.only(bottom: 5),
                                              child: Text('Gaji', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 14, color: Color.fromARGB(255, 90, 91, 103)),),
                                            ),
                                            Text( widget.data['show_gaji'] == 'Y' ? toRupiah(widget.data['gaji']) : '-', style: TextStyle(fontWeight: FontWeight.w600, color: Colors.blue),),
                                          ],
                                        ),
                                      ),
                                    ]
                                  ),
                                  SizedBox(height: 10), 
                                  Wrap(
                                    spacing: 5.0,
                                    runSpacing: 5.0,
                                    direction: Axis.horizontal,
                                    crossAxisAlignment: WrapCrossAlignment.center,
                                    // mainAxisAlignment: MainAxisAlignment.center,
                                    children: [
                                      TextInfo(
                                        label: widget.data['jenis_pekerjaan'],
                                        color:  Colors.green
                                      ),
                                      TextInfo(
                                        label: widget.data['pendidikan'],
                                        color:   Colors.orange
                                      ),
                                    ],
                                  )
                                ],
                              ),
                            )
                          ],
                        )
                      ),
                      ConstrainedBox(
                        constraints: BoxConstraints(minHeight: 500),
                        child: Container(
                          width: double.infinity,
                          decoration: BoxDecoration(
                              borderRadius: BorderRadius.all(Radius.circular(20)),
                              color: Color.fromARGB(255, 240,243,244),
                          ),
                          margin: EdgeInsets.only(top: 20),
                          padding:  EdgeInsets.only(top: 15, left: 30, right: 30),
                          child: _isLoading ? Center(child: CircularProgressIndicator()) : Container(
                            child: Column(
                              mainAxisAlignment: MainAxisAlignment.start,
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                SizedBox(height: 10), 
                                Text('Deskripsi :', style: TextStyle(fontSize: 18, fontWeight: FontWeight.w600), textAlign: TextAlign.center,),
                                Text(parseHtml(widget.data['deskripsi']), textAlign: TextAlign.left,),
                                SizedBox(height: 10), 
                                MediaQuery.removePadding(
                                  context: context,
                                  removeTop: true,
                                  removeBottom: true,
                                  child: ListView.builder(
                                    shrinkWrap: true,
                                    physics: NeverScrollableScrollPhysics(),
                                    itemCount: detil['deskripsi'].length,
                                      itemBuilder: (context, i){
                                        return Container(
                                          alignment: Alignment.topLeft,
                                          child:  Column(
                                            mainAxisAlignment: MainAxisAlignment.start,
                                            crossAxisAlignment: CrossAxisAlignment.start,
                                            children: [
                                              Text('${detil['deskripsi'][i]['judul_deskripsi']} :', style: TextStyle(fontSize: 18, fontWeight: FontWeight.w600), textAlign: TextAlign.start,),
                                              MediaQuery.removePadding(
                                                context: context,
                                                removeTop: true,
                                                child: ListView.builder(
                                                  shrinkWrap: true,
                                                  physics: NeverScrollableScrollPhysics(),
                                                  itemCount: detil['deskripsi'][i]['detil'].length,
                                                    itemBuilder: (context, j){
                                                      return  Row(
                                                          mainAxisAlignment: MainAxisAlignment.start,
                                                          crossAxisAlignment: CrossAxisAlignment.start,
                                                          children: [
                                                            Icon(LineAwesomeIcons.dot_circle),
                                                            Flexible(child: Text(detil['deskripsi'][i]['detil'][j]['keterangan']))
                                                          ]
                                                        );
                                                    }
                                                )
                                              )
                                            ],
                                          ),
                                        );
                                      },
                                  ),
                                ),
                                SizedBox(height: 10), 
                                Text('Keahlian :', style: TextStyle(fontSize: 18, fontWeight: FontWeight.w600), textAlign: TextAlign.center,),
                                Text(detil['keahlian'].map((e) => e['nama_choice']).toList().join(', ')),
                                SizedBox(height: 10), 
                                Text('Bahasa :', style: TextStyle(fontSize: 18, fontWeight: FontWeight.w600), textAlign: TextAlign.center,),
                                Text(detil['bahasa'].map((e) => e['nama_choice']).toList().join(', ')),
                                ElevatedButton(
                                  onPressed: (){
                                      Navigator.push(
                                        context,
                                        MaterialPageRoute(builder: (context) => PerusahaanDScreen(data: detil['profile']))
                                      );
                                  }, 
                                  child: Row(
                                    mainAxisAlignment: MainAxisAlignment.center,
                                    children:[
                                      Icon(LineAwesomeIcons.building),
                                      Text('   ' + detil['profile']['nama'])
                                  ])
                                ),
                              ],
                            ),
                          )
                        ),
                      )
                      
                    ],
                  ),
                )
              ),
              ]
          )
        )
    );
  }
}