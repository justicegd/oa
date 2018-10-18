# {{$name}}

### 【Request Method】
**`{{ $method }}`**

### 【Request URL】
**` {{$url}}`**

### **【Request URL Params/Data Params】**
key|value |說明 |是否必填
:---: | :---: |:---|:---:
@foreach($inDatas as $inData)
    {{$inData->cloumn}} | {{$inData->name}} | {{$inData->discription}} | {{$inData->necessary}}
@endforeach

### **【Data Origin】**
```json
```

### **【Data Parsed 】**
```json
```

### **【Response】** ###
key|value |說明
:---: | :---: |:---
result | | 回应代码
message | | 回应讯息
data | | 回应资料


##### **SUCCESS** #####
```json
{!! $returnJson !!}