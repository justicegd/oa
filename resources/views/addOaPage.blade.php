<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>


<form action="{{route('addOa')}}" method="post">
    @csrf
    <table>
        <tr>
            <td>回传讯息</td>
            <td>{{$msg or ''}}</td>
        </tr>
        <tr>
            <td>標題</td>
            <td><input type="text" name="title"></td>
        </tr>
        <tr>
            <td>內文</td>
            <td>
                <textarea name="content" >
                    <p><strong>
                    開發任務</strong></p>
                    <p>-------------------------------------------------------------------------------------------------</p>
                    <p>1. 需求者 ray</p>
                    <p>2. 詳細內容</p>
                    <br>
                    <br>
                    <p>3. 解決方法</p>
                    <p>4. 測試注意事項</p>
                    <p>&nbsp;</p>
                </textarea>
            </td>
        </tr>
        <tr>
            <td></td>
            <td ><input type="submit" value="送出"></td>
        </tr>
    </table>


</form>
<script>CKEDITOR.replace("content",{ height: '545px', width: '1318px' });</script>