import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:line_awesome_flutter/line_awesome_flutter.dart';
import 'package:mobile/helpers/color.dart';
import 'package:flutter/services.dart';
import 'package:intl/intl.dart';
import 'package:material_design_icons_flutter/material_design_icons_flutter.dart';

import 'package:form_field_validator/form_field_validator.dart';
import 'package:mobile/helpers/icon_image_provider.dart';
import 'package:mobile/helpers/services.dart';

import 'package:html/parser.dart';

PreferredSizeWidget appBar(String text) {
  return AppBar(
        title          : Text(text, style: TextStyle(color: Colors.black)),
        elevation      : 0,
        iconTheme: IconThemeData(
          color: Colors.black, //change your color here
        ),
        backgroundColor: HexColor('#FFFFFF'),
      );
}

extension StringCasingExtension on String {
  String toCapitalized() => length > 0 ?'${this[0].toUpperCase()}${substring(1).toLowerCase()}':'';
  String toTitleCase() => replaceAll(RegExp(' +'), ' ').split(' ').map((str) => str.toCapitalized()).join(' ');
}

String parseHtml(String htmlString) {
  final document = parse(htmlString);
  final String parsedString = parse(document.body!.text).documentElement!.text;

  return parsedString;
}
toRupiah(number){
  final NumberFormat usCurrency = NumberFormat('#,##0', 'id_ID');
  return 'Rp. ${usCurrency.format(number)}';
}
const List<String> months = const <String>[
  'Januari',
  'Februari',
  'Maret',
  'April',
  'Mei',
  'Juni',
  'Juli',
  'Agustus',
  'September',
  'Oktober',
  'November',
  'Desember',
];

const List<String> value_months = const <String>[
  '01',
  '02',
  '03',
  '04',
  '05',
  '06',
  '07',
  '08',
  '09',
  '10',
  '11',
  '12',
];

const List<String> years = const <String>[
  '2019',
  '2020',
  '2021',
  '2022',
  '2023',
  '2024',
  '2025',
  '2026',
  '2027',
];

Widget barInfo(title, value, image){
  return Expanded(
    flex: 1,
    child: Container(
      decoration: BoxDecoration(
        borderRadius: BorderRadius.all(Radius.circular(5)),
        color: Colors.white,
        // border: Border.all(color: Color.fromARGB(255, 220, 220, 220)),
        
      ),
      margin: EdgeInsets.symmetric(horizontal: 5),
      padding: EdgeInsets.all(10),
      height: 85,
      child: Container(
        padding: EdgeInsets.all(10),
        decoration: BoxDecoration(
          // color: Colors.red,
          image: DecorationImage(
            alignment: Alignment.topLeft,
            fit: BoxFit.none,
            image: image,
            opacity: 0.2,
          ),
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.end,
          crossAxisAlignment: CrossAxisAlignment.end,
          children: [
            Text(value, style: TextStyle(fontSize: 20, fontWeight: FontWeight.w800),),
            Text(title, style: TextStyle(fontSize: 11, fontWeight: FontWeight.w800),),
          ],
        ),
      ),
    ),
  );
}
Widget barMenu(start, title, end, context, url){
  return InkWell(
    onTap: () {
       Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => url),
      );
    },
    child: Container(
      decoration: BoxDecoration(
        borderRadius: BorderRadius.all(Radius.circular(10)),
        color: Colors.white,
      ),
      padding: EdgeInsets.all(15),
      margin: EdgeInsets.symmetric(vertical: 5),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Row(
            children: [
             start,
              Text('    '),
              Text(title, style: TextStyle(color: Color.fromARGB(255,17,62,108), fontSize: 15),),
            ],
          ),
         end
        ]
      ),
    ),
  );
}

Widget menuList({required IconData icon, required String title, Widget? info, void Function()? onTap}){
  return InkWell(
    onTap: onTap,
    child: Container(
      decoration: BoxDecoration(
        borderRadius: BorderRadius.all(Radius.circular(10)),
        color: Colors.white,
      ),
      padding: EdgeInsets.all(15),
      margin: EdgeInsets.symmetric(vertical: 5),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Row(
            children: [
              Icon(icon, color: Color.fromARGB(255,17,62,108)),
              Text('    '),
              Text(title, style: TextStyle(color: Color.fromARGB(255,17,62,108), fontSize: 15),),
            ],
          ),
         info?? Container()
        ]
      ),
    ),
  );
}


class TextInfo extends StatefulWidget {
  final String label;
  final Color? color;
  const TextInfo({Key? key, required this.label, this.color = Colors.green}) : super(key: key);

  @override
  State<TextInfo> createState() => TextInfoState();
}

class TextInfoState extends State<TextInfo> {
  // String label = widget.label ?? 'Tes'; 

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: EdgeInsets.symmetric(horizontal: 15, vertical: 5),
      // margin: EdgeInsets.symmetric(horizontal: 5),
      decoration: BoxDecoration(
        color: widget.color?.withOpacity(0.3),
        borderRadius: BorderRadius.all(Radius.circular(25))
      ),
      child: Text(widget.label, style: TextStyle(color: widget.color),),
    );
  }
}

class BarMenu extends StatefulWidget {
  final IconData icon;
  final String label;
  final Widget? info;
  final void Function()? onTap;
  BarMenu({Key? key, required this.icon, required this.label, this.info, this.onTap}) : super(key: key);

  @override
  State<BarMenu> createState() => BarMenuState();
}

class BarMenuState extends State<BarMenu> {
  // String label = widget.label ?? 'Tes'; 

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: widget.onTap,
      child: Container(
        decoration: BoxDecoration(
          borderRadius: BorderRadius.all(Radius.circular(10)),
          color: Colors.white,
        ),
        padding: EdgeInsets.all(15),
        margin: EdgeInsets.symmetric(vertical: 5),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            Row(
              children: [
                Icon(widget.icon, color: Color.fromARGB(255,17,62,108)),
                Text('    '),
                Text(widget.label, style: TextStyle(color: Color.fromARGB(255,17,62,108), fontSize: 15),),
              ],
            ),
            widget.info ?? Container()
          ]
        ),
      ),
    );
  }
}

class Content extends StatefulWidget {
  final String label;
  final Widget? child;
  Content({Key? key, required this.label, this.child}) : super(key: key);

  @override
  State<Content> createState() => ContentState();
}

class ContentState extends State<Content> {
  // String label = widget.label ?? 'Tes'; 

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
                    Text(widget.label, style: TextStyle(fontSize: 22, fontWeight: FontWeight.w500, color: Colors.white),),
                    Icon(LineAwesomeIcons.info, color: Color.fromARGB(0, 1, 1, 1))
                  ],
                )
              ),
              Expanded(
                flex: 1,
                child:Container(
                  width: double.infinity,
                  // height: double.infinity,
                  decoration: BoxDecoration(
                      borderRadius: BorderRadius.only(topLeft: Radius.circular(20), topRight: Radius.circular(20)),
                      // color: Color.fromARGB(255, 243, 240, 240)
                      color: Color.fromARGB(255, 240,243,244),
                  ),
                  margin: EdgeInsets.only(top: 20),
                  // padding:  EdgeInsets.all(30),
                  child: widget.child
                )
              )
            ]
          )
        )
    );
  }
}

class Filter extends StatefulWidget {
  final String label;
  final Widget input;
  final void Function()? onPressed;
  final void Function()? onState;
  Filter({Key? key, required this.label, required this.input, this.onPressed, this.onState}) : super(key: key);

  @override
  State<Filter> createState() => FilterState();
}

class FilterState extends State<Filter> {
  @override
  Widget build(BuildContext context) {
    return InkWell(
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
                    widget.input,
                    ElevatedButton(
                      style: ButtonStyle(backgroundColor: MaterialStateProperty.all(Color.fromARGB(255,38,123,204))),
                      onPressed: widget.onPressed,
                      child: Row(
                        mainAxisSize: MainAxisSize.min,
                        children: [
                          Text("Filter ", style: TextStyle(fontSize: 18,),),
                          Icon(LineAwesomeIcons.search),
                        ],
                      ),
                    )
                  ],
                )
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
            Text(widget.label, style: TextStyle(color:  Color.fromARGB(255, 60,65,77), fontSize: 20, fontWeight: FontWeight.w700),),
            Icon(LineAwesomeIcons.search, color: Color.fromARGB(0, 60,65,77)),
          ]
        ),
      ),
    );
  }
}



String toNumberRupiah(value){
  return 'Rp. ${NumberFormat.decimalPattern('id_ID').format(value)}';
}

double dateToDouble(value){
  return double.parse(value.replaceAll('-', ''));
}
EdgeInsetsGeometry FormMargin = EdgeInsets.only(top: 5);

class FormLoading extends StatefulWidget {
  final String label;
  FormLoading({Key? key, required this.label}) : super(key: key);

  @override
  State<FormLoading> createState() => FormLoadingState();
}

class FormLoadingState extends State<FormLoading> {
  // String label = widget.label ?? 'Tes'; 

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: FormMargin,
      child: TextFormField(
        decoration: InputDecoration(
          labelText: widget.label,
          contentPadding: EdgeInsets.all(5),
          suffixIcon: Icon(MdiIcons.loading)
        ),
        initialValue: 'Loading ....',
        enabled: false,
        onEditingComplete: () => FocusScope.of(context).nextFocus(),
      ),
    );
  }
}

class FormText extends StatefulWidget {
  final String label;
  final dynamic initialValue;
  final bool disabled;
  final dynamic validator;
  final TextEditingController? valueController;
  final TextInputType? keyboardType;
  final bool isLoading;
  FormText({Key? key, required this.label, this.initialValue, this.disabled = false, this.validator, this.valueController, this.keyboardType, this.isLoading = false}) : super(key: key);

  @override
  State<FormText> createState() => FormTextState();
}

class FormTextState extends State<FormText> {
  // String label = widget.label ?? 'Tes'; 

  @override
  Widget build(BuildContext context) {
    if(widget.isLoading){
      return FormLoading(label: widget.label);
    }else{
      return Container(
        margin: FormMargin,
        child: TextFormField(
          decoration: InputDecoration(
            labelText: widget.label,
            contentPadding: EdgeInsets.all(5),
            // suffixIcon: Icon(MdiIcons.calendar)
          ),
          initialValue: widget.initialValue,
          enabled: !widget.disabled,
          controller: widget.valueController,
          keyboardType: widget.keyboardType,
          // validator: RequiredValidator(errorText: 'this field is required'),
          onEditingComplete: () => FocusScope.of(context).nextFocus(),
          validator: (val){
            // if (val!.isEmpty) {
            //   return '${widget.label} is empty';
            // }
            return null;
          },
        ),
      );
    }
  }
}

class FormSelect extends StatefulWidget {
  final String label;
  final bool disabled;
  final dynamic validator;
  final dynamic option;
  final TextEditingController valueController;
  final Function? refreshData;
  FormSelect({Key? key, required this.label, this.disabled = false, this.validator, required this.option, required this.valueController, this.refreshData = null}) : super(key: key);

  @override
  State<FormSelect> createState() => FormSelectState();
}


class FormSelectState extends State<FormSelect> {
  @override
  void initState() {
    super.initState();
    print('tess');
  }
  @override
  Widget build(BuildContext context) {
    return widget.option.length > 0 ? 
      _FormSelect(
        label          : widget.label,
        option         : widget.option,
        valueController: widget.valueController,
        key            : widget.key,
        disabled       : widget.disabled,
        validator      : widget.validator,
        refreshData    : widget.refreshData
      ) : FormLoading(label: widget.label);
  }
}

class _FormSelect extends StatefulWidget {
  final String label;
  final bool disabled;
  final dynamic validator;
  final dynamic option;
  final TextEditingController valueController;
  final Function? refreshData;
  _FormSelect({Key? key, required this.label, this.disabled = false, this.validator, required this.option, required this.valueController, this.refreshData}) : super(key: key);

  @override
  State<_FormSelect> createState() => _FormSelectState();
}

class _FormSelectState extends State<_FormSelect> {

  TextEditingController get _effectiveController => widget.valueController;
  TextEditingController textController = TextEditingController();
 
  @override
  void initState() {
    var initialName = '';
    var initialValue = '';
    if(widget.option.length > 0){
      if(widget.valueController.text == ''){
        initialName = widget.option[0]['name'];
        initialValue = widget.option[0]['value'];
      }else{
        initialName = widget.option.where((e) => e['value'].toString() == widget.valueController.text).toList()[0]['name'];
        initialValue = widget.option.where((e) => e['value'].toString() == widget.valueController.text).toList()[0]['value'].toString();
      }
    }

    setState(() {
      textController            = TextEditingController(text:  initialName);
      _effectiveController.text = initialValue;
    });
    super.initState();
  }
  @override
  void didChangeDependencies() {
    super.didChangeDependencies();
    // set your stuff here 
    // print('tes');
  }


  @override
  Widget build(BuildContext context) {
    return Container(
      margin: FormMargin,
      child: TextFormField(
        decoration: InputDecoration(
          labelText: widget.label,
          contentPadding: EdgeInsets.all(5),
          suffixIcon: Icon(MdiIcons.panDown)
        ),
        readOnly: true,
        enabled: !widget.disabled,
        controller: textController,
        onTap: (){
          showDialog(context: context, builder: (_) =>Dialog(
            child: Container(
              // height: MediaQuery.of(context).size.height / 2,
              // color: Colors.red,
              width : double.infinity,
              child : Column(
                children: [
                  Container(
                    decoration: BoxDecoration(
                      border: Border(
                        bottom: BorderSide(color: MyColor('line'), width: 1)
                      )
                    ),
                    padding: EdgeInsets.only(left: 15, right: 15, top: 5, bottom: 5),
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        Text(widget.label, style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: HexColor('#1d608a'))),
                        ElevatedButton(
                          onPressed: () {
                            Navigator.pop(context);
                          },
                          child: Icon(Icons.close, color: Colors.grey.shade800, size: 16),
                          style: ElevatedButton.styleFrom(
                            minimumSize: Size(0, 0),
                            shape: CircleBorder(),
                            padding: EdgeInsets.all(5),
                            primary: Colors.grey,
                            onPrimary: Colors.black,
                          ),
                        )
                      ],
                    ),
                  ),
                  Expanded(
                    child: SingleChildScrollView(
                       physics: ScrollPhysics(),
                      child: Container(
                        // color: Colors.green,
                        margin: EdgeInsets.all(10),
                        child: ListView.builder(
                          physics: NeverScrollableScrollPhysics(),
                          itemCount: widget.option.length,
                          // controller: _scrollController,
                          shrinkWrap: true,
                            itemBuilder: (context, i){
                              return InkWell(
                                onTap: (){
                                  if(widget.refreshData != null){
                                    widget.refreshData!(widget.option[i]['value']);
                                  }
                                  setState(() {
                                    textController = TextEditingController(text: widget.option[i]['name']);
                                  });
                                  _effectiveController.text = widget.option[i]['value'].toString() ?? ''; 
                                  Navigator.pop(context);
                                },
                                child: Container(
                                  padding: EdgeInsets.all(15),
                                  width: double.infinity,
                                  decoration: BoxDecoration(
                                    border: Border(
                                      bottom: BorderSide(color: MyColor('bg'), width: 1)
                                    ),
                                    // color: Colors.white
                                  ),
                                  child: Text(widget.option[i]['name'] ?? ''),
                                ),
                              );
                            },
                        ),
                      ),
                    ),
                  )
                ],
              ),
            ),
          ));
        },
        validator: (val){
          if (val!.isEmpty) {
            return '${widget.label} is empty';
          }
          return null;
        },
        onEditingComplete: () => FocusScope.of(context).nextFocus(),
      ),
    );
  }
}
class FormDate extends StatefulWidget{

  final String label;
  final bool disabled;
  final dynamic validator;
  final TextEditingController valueController;
  final bool isLoading;
  FormDate({Key? key, required this.label, this.disabled = false, this.validator, required this.valueController, this.isLoading = false}) : super(key: key);

  @override
  State<FormDate> createState() => _FormDateState();
}

class _FormDateState extends State<FormDate> {
  @override
  Widget build(BuildContext context) {
    if(widget.isLoading){
      return FormLoading(label: widget.label);
    }else{
      return FormDate2(
        label          : widget.label,
        disabled       : widget.disabled,
        validator      : widget.validator,
        valueController: widget.valueController,
      );
    }
  }
}
class FormDate2 extends StatefulWidget {
  final String label;
  final bool disabled;
  final dynamic validator;
  final TextEditingController valueController;
  FormDate2({Key? key, required this.label, this.disabled = false, this.validator, required this.valueController}) : super(key: key);

  @override
  State<FormDate2> createState() => FormDate2State();
}


class FormDate2State extends State<FormDate2> {

  TextEditingController get _effectiveController => widget.valueController;
  TextEditingController textController = TextEditingController();
  DateTime selectedDate = DateTime.now();

  _selectDate(BuildContext context) async {
    final DateTime? picked = await showDatePicker(
      context    : context,
      initialDate: new DateFormat("y-MM-d").parse(widget.valueController.text),   // Refer step 1
      firstDate  : DateTime(1800),
      lastDate   : DateTime(2045),
    );
    if (picked != null && picked != new DateFormat("y-MM-dd").parse(widget.valueController.text))
      setState(() {
        selectedDate = picked;
      });
      
    _effectiveController.text = DateFormat('y-MM-dd').format(picked ?? new DateFormat("y-MM-dd").parse(widget.valueController.text));
    textController = TextEditingController(text: DateFormat('y-MM-dd').format(picked ?? new DateFormat("y-MM-dd").parse(widget.valueController.text)));
  }

  @override
  void initState() {
    print(widget.valueController.text);
    setState(() {
      textController = TextEditingController(text:  widget.valueController.text);
    });
    super.initState();
  }
  @override
  Widget build(BuildContext context) {
    return Container(
      margin: FormMargin,
      child: TextFormField(
        decoration: InputDecoration(
          labelText: widget.label,
          contentPadding: EdgeInsets.all(5),
          suffixIcon: Icon(MdiIcons.calendar)
        ),
        readOnly: true,
        enabled: !widget.disabled,
        controller: textController,
        onTap: (){
          _selectDate(context);
        },
        // validator: (val){
        //   formValidation(val, widget);
        // },
        onEditingComplete: () => FocusScope.of(context).nextFocus(),
      ),
    );
  }
}

// formValidation(val, widget){
//   String label     = widget.label;
//   String validator = widget.validator;
//   if (val!.isEmpty) {
//     return '${label} is empty';
//   }
//   return null;
// }