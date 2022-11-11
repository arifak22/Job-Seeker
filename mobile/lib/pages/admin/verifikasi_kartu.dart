import 'package:flutter/material.dart';
import 'package:line_awesome_flutter/line_awesome_flutter.dart';
import 'package:mobile/helpers/icon_image_provider.dart';
import 'package:mobile/helpers/services.dart';
import 'package:mobile/helpers/widget.dart';

class VerifikasiKartu extends StatefulWidget {
  @override
  _VerifikasiKartuState createState() => _VerifikasiKartuState();
}


class _VerifikasiKartuState extends State<VerifikasiKartu> {
TextEditingController valueKecamatan    = TextEditingController();
TextEditingController valueKelurahan    = TextEditingController();
TextEditingController valueKeterangan   = TextEditingController();
dynamic               optionIjinPenting = [];


Widget contentRoundImage({image}){
  return Container(
    width: 50.0,
    height: 50.0,
    decoration:  BoxDecoration(
      shape: BoxShape.circle,
      color: Colors.white,
      image:  DecorationImage(
          fit: BoxFit.contain,
          image: image
      )
    )
  );
}
Widget contentTitle({title, icon, text}){
  return Container(
    height: 50,
    // color: Colors.red,
    margin: EdgeInsets.only(left: 10),
    padding: EdgeInsets.symmetric(vertical: 5),
    alignment: Alignment.topLeft,
    child: Column(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,  
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(' '+title, style: TextStyle(fontSize: 16, fontWeight: FontWeight.w700),),
        Row(
          children: [
            Icon(icon, size: 18,),
            Text(" "+text, style: TextStyle(fontSize: 13, fontWeight: FontWeight.w600),)
          ],
        )
      ],
    )
  );
}
Widget contentFooter({content}){
  return Container(
    margin: EdgeInsets.only(top: 15),
    child: 
    Row(
      children: content
      
    ),
  );
}
Widget footerValue({title, value, color}){
  return Expanded(
    flex: 1,
    child: Column(
      mainAxisAlignment: MainAxisAlignment.start,
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Padding(
          padding: const EdgeInsets.only(bottom: 5),
          child: Text(title, style: TextStyle(fontWeight: FontWeight.bold, fontSize: 14, color: Color.fromARGB(255, 90, 91, 103)),),
        ),
        Text(value, style: TextStyle(fontWeight: FontWeight.w600, color: color),),
      ],
    )
  );
}
Widget barContent({roundImage, title, footer}){
  return Container(
    width: double.infinity,
    padding: EdgeInsets.all(15),
    margin: EdgeInsets.only(bottom: 5, top: 5),
    decoration: BoxDecoration(
      borderRadius: BorderRadius.all(Radius.circular(15)),
      color: Colors.white,
      border: Border.all(color: Color.fromARGB(255, 207, 210, 213), width: 0.2)
    ),
    child: Column(
      children: [
        Container(
          padding: EdgeInsets.only(bottom: 15),
          decoration: BoxDecoration(
            color: Colors.white,
            // boxShadow: [BoxShadow(color: Colors.black, )]
            border: Border(
              bottom: BorderSide(width: 0.5, color: Color.fromARGB(255, 207, 210, 213)),
            ),
          ),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.start,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              roundImage,
              title
            ],
          ),
        ),
       footer
         
      ],
    )
  );
}
  dynamic optionKecamatan;
  dynamic optionKelurahan = ['test', 'test 2'];
  Future? citiesFuture; // the cities future
  Future? areasFuture; // the data for the second drop down
// dynamic option = [];
  getKecamatan() async {
      return await Services().getApi('option', "search=kecamatan").then((val) {
      if (val['api_status'] == 1) {
        return val['data'];
      }else{
        return [];
      }
    });
  }
  List<String> list = <String>['One', 'Two', 'Three', 'Four'];
  
  getKelurahan(id) async {
      return await Services().getApi('option', "search=kelurahan&id=${id}").then((val) {
      if (val['api_status'] == 1) {
        print(val);
        return val['data'];
      }else{
        return [];
      }
    });
  }

  @override
  void initState() {
    // TODO: implement initState
    super.initState();
    citiesFuture = getKecamatan();
    // getKelurahan();
  }
    // Widget provideSecondDropdown() {
    //     if (areasFuture == null) {
    //       // the user didn't select anything from the first dropdown so you probably want to show a disabled dropdown
    //       return Text('tes');
    //     }
    //     // return the FutureBuilder based on what the user selected
    //     return FutureBuilder(future: areasFuture, builder: (BuildContext context, AsyncSnapshot<dynamic> snapshot) {
    //                       List areas = snapshot.hasData ? snapshot.data : [] ;
    //                       print(snapshot);
    //                       return 
    //                       FormSelect(
    //                                   label          : 'Kelurahan',
    //                                   valueController: valueKelurahan,
    //                                   option         : areas,
    //                                 );
    //                     });
    // }
  @override
  Widget build(BuildContext context) {
      String dropdownValue = list.first;
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
                 margin: EdgeInsets.only(top: 50),
                child: Text('title', style: TextStyle(fontSize: 30, fontWeight: FontWeight.w500, color: Colors.white),)
              ),
              Expanded(
                flex: 1,
                child: Container(
                  width: double.infinity,
                  // height: double.infinity,
                  decoration: BoxDecoration(
                      borderRadius: BorderRadius.only(topLeft: Radius.circular(20), topRight: Radius.circular(20)),
                      // color: Color.fromARGB(255, 243, 240, 240)
                      color: Color.fromARGB(255, 240,243,244),
                  ),
                  margin: EdgeInsets.only(top: 20),
                  // padding:  EdgeInsets.all(30),
                  child: Column(
                    children: [
                      InkWell(
                        onTap: (){
                          showModalBottomSheet<void>(
                            shape: const RoundedRectangleBorder(
                              borderRadius: BorderRadius.only(
                                topLeft: Radius.circular(35.0),
                                topRight: Radius.circular(35.0),
                              ),
                            ),
                            context: context,
                            builder: (BuildContext context) {
                              return StatefulBuilder(builder: (BuildContext context, StateSetter mystate) {
                                return Container(
                                  decoration: BoxDecoration(
                                    
                                    color: Colors.white,
                                    borderRadius: BorderRadius.only(topLeft: Radius.circular(35), topRight: Radius.circular(35)),
                                  ),
                                  padding: EdgeInsets.only(bottom: 40, left: 20, right: 20),
                                  child: Column(
                                    mainAxisSize: MainAxisSize.min,
                                    children: [
                                      Padding(
                                        padding: EdgeInsets.fromLTRB(100, 20, 100, 20),
                                        child: Container(
                                          height: 8,
                                          width: 130,
                                          decoration: BoxDecoration(
                                            color: Color.fromARGB(255, 196, 195, 195),
                                            borderRadius: BorderRadius.all(Radius.circular(8))
                                          ),
                                        ),
                                      ),
                                      FormText(
                                        label          : 'Keterangan',
                                        valueController: valueKeterangan,
                                        // isLoading      : !_isReady,
                                      ),
                                      FutureBuilder(future: citiesFuture, builder: (BuildContext context, AsyncSnapshot<dynamic> snapshot) {
                                        List cities = snapshot.hasData ? snapshot.data : [];
                                        // print(snapshot);
                                        print('kecamatan' + snapshot.toString());
                                        return FormSelect(
                                          label          : 'Kecamatan',
                                          valueController: valueKecamatan,
                                          option         : cities,
                                          refreshData: (){
                                            mystate(() {
                                              valueKecamatan.text = valueKecamatan.text;
                                              areasFuture = getKelurahan(valueKecamatan.text);
                                            });
                                          },
                                        );
                                      }),
                                      ElevatedButton(onPressed: (){
                                        mystate((){
                                          areasFuture = getKelurahan(2101011);
                                        });
                                      }, child: Text('tess')),
                                      FutureBuilder(future: areasFuture, builder: (BuildContext context, AsyncSnapshot<dynamic> snapshot) {
                                          List areas = snapshot.hasData ? snapshot.data : [] ;
                                          print('test' + snapshot.toString());
                                          return 
                                          FormSelect(
                                            label          : 'Kelurahan',
                                            valueController: valueKelurahan,
                                            option         : areas,
                                          );
                                        }),
                                      // FormSelect(
                                      //   label          : 'Kelurahan',
                                      //   valueController: valueKelurahan,
                                      //   option         : optionKelurahan,
                                      // ),
                                      ElevatedButton(
                                        style: ButtonStyle(backgroundColor: MaterialStateProperty.all(Color.fromARGB(255,38,123,204))),
                                        child: Row(
                                          mainAxisSize: MainAxisSize.min,
                                          children: [
                                            Text("Filter ", style: TextStyle(fontSize: 18,),),
                                            Icon(LineAwesomeIcons.search),
                                          ],
                                        ),
                                        onPressed: (){

                                        },
                                      )
                                    ],
                                  )
                                );
                              }
                              );
                            },
                          );
                        },
                        child: Container(
                          width: double.infinity,
                          height: 60,
                          // height: double.infinity,
                          decoration: BoxDecoration(
                              borderRadius: BorderRadius.only(topLeft: Radius.circular(20), topRight: Radius.circular(20)),
                              color: Color.fromARGB(255, 244,247,249),
                              border: Border.all(color: Color.fromARGB(255, 207, 210, 213), width: 0.5)
                          ),
                          padding: EdgeInsets.all(15),
                          child: Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: [
                              Icon(LineAwesomeIcons.horizontal_sliders, color: Color.fromARGB(255, 60,65,77)),
                              Text('Filter Title', style: TextStyle(color:  Color.fromARGB(255, 60,65,77), fontSize: 20, fontWeight: FontWeight.w700),),
                              Icon(LineAwesomeIcons.search, color: Color.fromARGB(0, 60,65,77)),
                            ]
                          ),
                        ),
                      ),
                      Container(
                      width: double.infinity,
                      margin: EdgeInsets.only(left: 15, right: 15, top: 20),
                      child: Column(
                        children: [
                            barContent(
                              roundImage: contentRoundImage(
                                image: NetworkImage("https://siapnari.disnakerprind.info/storage/app/pencarikerja/gambar/gambar-nHzUT-21.png")
                              ),
                              title: contentTitle(
                                title: 'Judul',
                                icon: LineAwesomeIcons.map_marker,
                                text: "MORO, MORO TIMUR"
                              ),
                              footer: contentFooter(
                                content: [
                                  footerValue(
                                    title: 'Masa Berlaku',
                                    value: '29 September 2022',
                                    color: Colors.blue,
                                  ),
                                  footerValue(
                                    title: 'Gaji',
                                    value: '29 September 2022',
                                    color: Colors.green,
                                  ),
                                ]
                              )
                            ),
                          ],
                        ),
                      ),
                    ],
                  )
                ),
              ),
            ],
          )
        )
      );
  }
}