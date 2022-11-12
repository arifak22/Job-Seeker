import 'package:flutter/material.dart';
import 'package:http_query_string/http_query_string.dart';
import 'package:intl/intl.dart';
import 'package:line_awesome_flutter/line_awesome_flutter.dart';
import 'package:mobile/helpers/content_bar.dart';
import 'package:mobile/helpers/services.dart';
import 'package:mobile/helpers/widget.dart';
import 'package:mobile/pages/home/perusahaan_d_screen.dart';

class PerusahaanScreen extends StatefulWidget {
  @override
  _PerusahaanScreenState createState() => _PerusahaanScreenState();
}


class _PerusahaanScreenState extends State<PerusahaanScreen> {
  TextEditingController valueKecamatan = TextEditingController();
  TextEditingController valueKelurahan = TextEditingController();
  TextEditingController valueSearch    = TextEditingController();
  String? value;
  Future? _kecamatanOption;
  Future? _kelurahanOption;
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
      'search'      : valueSearch.text,
      'tipe'        : 'mobile'
    });

    setState(() {
      _isLoading = true;
    });
    await Services().getApi('perusahaan', parameters).then((value) {
        if(value['api_status'] == 1){
          print(value);
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
    getData();
  }

  @override
  Widget build(BuildContext context) {
    return Content(
      label: 'Perusahaan',
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
                              MaterialPageRoute(builder: (context) => PerusahaanDScreen(data: data[i]))
                            );
                          },
                          roundImage: RoundImage(image: NetworkImage(localStorage(data[i]['foto']))), 
                          titleContent: TitleContent(title: data[i]['nama'], icon: LineAwesomeIcons.map_marker, description: data[i]['nama_kecamatan'] + ', ' + data[i]['nama_kelurahan']), 
                          footerContent: FooterContent(
                            children: [
                              FooterContentChild(title: 'Loker Aktif', description: data[i]['jumlah_loker'].toString()),
                              FooterContentChild(title: 'Bidang Usaha', description: data[i]['nama_bidang']),
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