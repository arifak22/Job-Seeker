import 'package:flutter/material.dart';
import 'package:http_query_string/http_query_string.dart';
import 'package:intl/intl.dart';
import 'package:line_awesome_flutter/line_awesome_flutter.dart';
import 'package:mobile/helpers/content_bar.dart';
import 'package:mobile/helpers/services.dart';
import 'package:mobile/helpers/widget.dart';
import 'package:mobile/pages/home/loker_d_screen.dart';

class LokerScreen extends StatefulWidget {
  @override
  _LokerScreenState createState() => _LokerScreenState();
}


class _LokerScreenState extends State<LokerScreen> {
  TextEditingController valueKecamatan = TextEditingController();
  TextEditingController valueKelurahan = TextEditingController();
  TextEditingController valueKeahlian  = TextEditingController();
  TextEditingController valueBahasa    = TextEditingController();
  TextEditingController valueSearch    = TextEditingController();
  String? value;
  Future? _kecamatanOption;
  Future? _kelurahanOption;
  Future? _keahlianOption;
  Future? _bahasaOption;
  bool show = true;
  
  bool _isLoading = true;
  List data = [];

  getOption({required name, all = '1', id = '', callback}) async{
    if(!mounted) return;
    return await Services().getApi('option', "search=${name}&all=${all}&id=${id}").then((val) {
      if (val['api_status'] == 1) {
        callback(val['data'][0]['value']);
        return val['data'];
      }else{
        return [];
      }
    });
  }

  getData() async{
    if(!mounted) return;

    var parameters = Encoder().convert(<String, dynamic>{
      'id_kecamatan': valueKecamatan.text,
      'id_kelurahan': valueKelurahan.text,
      'id_keahlian' : valueKeahlian.text,
      'id_bahasa'   : valueBahasa.text,
      'search'      : valueSearch.text,
      'tipe'        : 'mobile'
    });

    setState(() {
      _isLoading = true;
    });
    await Services().getApi('loker', parameters).then((value) {
        if(value['api_status'] == 1){
           setState(() {
              data = value['data'];
              _isLoading = false;
           });
        }else{
          setState(() {
            data = [];
            _isLoading = false;
          });
        }
      }
    );
  }
  
  @override
  void initState() {
    super.initState();
    _kecamatanOption = getOption(
      name    : 'kecamatan',
      all     : '1',
      callback: (value){},

    );

    _kelurahanOption = getOption(
      name: 'kelurahan', 
      all:'1',
      callback: (value){},

    );

    _bahasaOption = getOption(
      name: 'bahasa', 
      all:'1',
      callback: (value){},

    );

    _keahlianOption = getOption(
      name: 'keahlian', 
      all:'1',
      callback: (value){},
    );

    getData();
  }

  @override
  Widget build(BuildContext context) {
    return Content(
      label: 'Lowongan Kerja',
      child: Column(
        children: [
          Filter(
            label: 'Filter',
            input: 
            StatefulBuilder(builder: (BuildContext context, StateSetter mystate) {
            return Container(
              child: Column(
                children: [
                  FormText(
                    label          : 'Kata kunci',
                    valueController: valueSearch,
                  ),
                  FutureBuilder(future: _kecamatanOption, builder: (BuildContext context, AsyncSnapshot<dynamic> snapshot) {
                      List option = snapshot.hasData ? snapshot.data : [];
                      return FormSelect(
                        label          : 'Kecamatan',
                        valueController: valueKecamatan,
                        option         : option,
                        refreshData: (value){
                          mystate(() {
                            valueKecamatan.text = valueKecamatan.text;
                            show = false;
                          });
                          // _kelurahanOption = [];
                          _kelurahanOption = getOption(
                            name    : 'kelurahan',
                            all     : '1',
                            id:  value,
                            callback: (value){
                              mystate(() {
                                valueKelurahan.text = value;
                                show = true;
                              });
                            },
                          );
                        }
                      );
                    },
                  ),
                  show ? FutureBuilder(future: _kelurahanOption, builder: (BuildContext context, AsyncSnapshot<dynamic> snapshot) {
                      List option = snapshot.hasData ? snapshot.data : [];
                      return FormSelect(
                        label          : 'Kelurahan',
                        valueController: valueKelurahan,
                        option         : option,
                      );
                    },
                  ) : FormLoading(label: 'Kelurahan'),
                  FutureBuilder(future: _keahlianOption, builder: (BuildContext context, AsyncSnapshot<dynamic> snapshot) {
                      List option = snapshot.hasData ? snapshot.data : [];
                      return FormSelect(
                        label          : 'Keahlian',
                        valueController: valueKeahlian,
                        option         : option,
                      );
                    },
                  ),
                  FutureBuilder(future: _bahasaOption, builder: (BuildContext context, AsyncSnapshot<dynamic> snapshot) {
                      List option = snapshot.hasData ? snapshot.data : [];
                      return FormSelect(
                        label          : 'Bahasa',
                        valueController: valueBahasa,
                        option         : option,
                      );
                    },
                  ),
                ]
              ),
            );
            }),
            onPressed: (){
              Navigator.pop(context);
              getData();
           
          }),
          Expanded(
            flex: 1,
            child:Container(
              // alignment: Alignment.topCenter,
              // color: Colors.red,
              margin: EdgeInsets.symmetric(horizontal: 20),
              // padding: EdgeInsets.symmetric(vertical: 20),
              child: _isLoading ? Center(child: CircularProgressIndicator()) : RefreshIndicator(
                onRefresh: () async{
                  getData();
                },
                child: MediaQuery.removePadding(
                  context: context,
                  removeTop: true,
                  child: ListView.builder(
                    itemCount: data.length,
                    // controller: _scrollController,
                      itemBuilder: (context, i){
                        // print(data[i]);
                        return ContentBar(
                          onTap: (){
                            Navigator.push(
                              context,
                              MaterialPageRoute(builder: (context) => LokerDScreen(data: data[i]))
                            );
                          },
                          roundImage: RoundImage(image: NetworkImage(localStorage(data[i]['foto_perusahaan']))), 
                          titleContent: TitleContent(title: data[i]['judul'], icon: LineAwesomeIcons.map_marker, description: data[i]['kecamatan'] + ', ' + data[i]['kelurahan']), 
                          footerContent: FooterContent(
                            children: [
                              FooterContentChild(title: 'Masa Berlaku', description: DateFormat('d MMMM y', 'id_ID').format(DateTime.parse(data[i]['tanggal_kadaluarsa']))),
                              FooterContentChild(title: 'Gaji', description: data[i]['show_gaji'] == 'Y' ? toRupiah(data[i]['gaji']) : '-'),
                            ],
                          )
                        );
                      },
                  ),
                ),
              ),
            )
          )
        ]
      )
    );
  }
}