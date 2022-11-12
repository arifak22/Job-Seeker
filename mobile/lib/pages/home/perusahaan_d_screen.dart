import 'package:flutter/material.dart';
import 'package:http_query_string/http_query_string.dart';
import 'package:intl/intl.dart';
import 'package:line_awesome_flutter/line_awesome_flutter.dart';
import 'package:mobile/helpers/content_bar.dart';
import 'package:mobile/helpers/services.dart';
import 'package:mobile/helpers/widget.dart';
import 'package:mobile/pages/home/loker_d_screen.dart';

class PerusahaanDScreen extends StatefulWidget {
  dynamic data;
  @override

  PerusahaanDScreen({Key? key, required this.data}) : super(key: key);
  _PerusahaanDScreenState createState() => _PerusahaanDScreenState();
}


class _PerusahaanDScreenState extends State<PerusahaanDScreen> {
    bool    _isLoading   = true;
    dynamic detil        = [];
    dynamic id_privilege = 0;


    getData() async{
      if(!mounted) return;
      var parameters = Encoder().convert(<String, dynamic>{
        'id': widget.data['id'],
      });

      setState(() {
        _isLoading = true;
      });
      await Services().getApi('perusahaan-detil', parameters).then((value) {
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
                    Text('Detil Perusahaan', style: TextStyle(fontSize: 22, fontWeight: FontWeight.w500, color: Colors.white),),
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
                              image: NetworkImage(localStorage(widget.data['foto']))
                            ),
                            SizedBox(height: 10), 
                            Text(widget.data['nama'], textAlign: TextAlign.center, style: TextStyle(color: Colors.white, fontSize: 20, fontWeight: FontWeight.w600),),
                            SizedBox(height: 10), 
                            Row(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                Icon(LineAwesomeIcons.map_marker, size: 18, color: Colors.white),
                                Text(" ${widget.data['nama_kecamatan']}, ${widget.data['nama_kelurahan']}", style: TextStyle(fontSize: 13, color: Colors.white, fontWeight: FontWeight.w600),)
                              ],
                            ),
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
                                mainAxisAlignment: MainAxisAlignment.start,
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Row(
                                    mainAxisAlignment: MainAxisAlignment.spaceAround,
                                    children: [
                                      Container(
                                        padding: EdgeInsets.symmetric(horizontal: 15),
                                        child: Column(
                                          mainAxisAlignment: MainAxisAlignment.start,
                                          crossAxisAlignment: CrossAxisAlignment.start,
                                          children: [
                                            Padding(
                                              padding: const EdgeInsets.only(bottom: 5),
                                              child: Text('Loker Aktif', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 14, color: Color.fromARGB(255, 90, 91, 103)),),
                                            ),
                                            Text( widget.data['jumlah_loker'].toString(), style: TextStyle(fontWeight: FontWeight.w600, color: Colors.blue),),
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
                                              child: Text('Bidang Usaha', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 14, color: Color.fromARGB(255, 90, 91, 103)),),
                                            ),
                                            Text( widget.data['nama_bidang'], style: TextStyle(fontWeight: FontWeight.w600, color: Colors.blue),),
                                          ],
                                        ),
                                      ),
                                    ]
                                  ),
                                  SizedBox(height: 10), 
                                  Container(
                                    alignment: Alignment.center,
                                    child: Wrap(
                                      spacing: 5.0,
                                      runSpacing: 5.0,
                                      direction: Axis.horizontal,
                                      crossAxisAlignment: WrapCrossAlignment.center,
                                      // mainAxisAlignment: MainAxisAlignment.center,
                                      children: [
                                        TextInfo(
                                          label: 'Pekerja Lokal: ${widget.data['pegawai_lokal'].toString()}',
                                          color:  Colors.green
                                        ),
                                        TextInfo(
                                          label: 'Pekerja Asing: ${widget.data['pegawai_asing'].toString()}',
                                          color:   Colors.orange
                                        ),
                                      ],
                                    ),
                                  ),

                                  SizedBox(height: 10), 
                                  Container(
                                    alignment: Alignment.topLeft,
                                    margin: EdgeInsets.symmetric(horizontal: 15, vertical: 5),
                                    padding: EdgeInsets.only(top: 10),
                                    decoration: BoxDecoration(
                                      border: Border(
                                        top: BorderSide(width: 1, color: Color.fromARGB(255, 197, 198, 198), ),
                                      ),
                                    ),
                                    child: Column(
                                      crossAxisAlignment: CrossAxisAlignment.start,
                                      mainAxisAlignment: MainAxisAlignment.start,
                                      children: [
                                        Text('Deskripsi :', style: TextStyle(fontSize: 18, fontWeight: FontWeight.w600), textAlign: TextAlign.left,),
                                        Text(parseHtml(widget.data['deskripsi']), textAlign: TextAlign.left,),
                                      ],
                                    ),
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
                                Text('Lowongan Aktif Terbuka :', style: TextStyle(fontSize: 18, fontWeight: FontWeight.w600), textAlign: TextAlign.center,),
                                SizedBox(height: 5), 
                                MediaQuery.removePadding(
                                  context: context,
                                  removeTop: true,
                                  child: ListView.builder(
                                    shrinkWrap: true,
                                    physics: NeverScrollableScrollPhysics(),
                                    itemCount: detil['job'].length,
                                      itemBuilder: (context, i){
                                        return ContentBar(
                                          onTap: (){
                                            Navigator.push(
                                              context,
                                              MaterialPageRoute(builder: (context) => LokerDScreen(data: detil['job'][i]))
                                            );
                                          },
                                          roundImage: RoundImage(image: NetworkImage(localStorage(detil['job'][i]['foto_perusahaan']))), 
                                          titleContent: TitleContent(title: detil['job'][i]['judul'], icon: LineAwesomeIcons.map_marker, description: detil['job'][i]['kecamatan'] + ', ' + detil['job'][i]['kelurahan']), 
                                          footerContent: FooterContent(
                                            children: [
                                              FooterContentChild(title: 'Masa Berlaku', description: DateFormat('d MMMM y', 'id_ID').format(DateTime.parse(detil['job'][i]['tanggal_kadaluarsa']))),
                                              FooterContentChild(title: 'Gaji', description: detil['job'][i]['show_gaji'] == 'Y' ? toRupiah(detil['job'][i]['gaji']) : '-'),
                                            ],
                                          )
                                        );
                                      }
                                  )
                                )
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