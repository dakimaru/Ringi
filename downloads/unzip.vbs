Public Function Unzip(DefPath, Fname)
'Unzips A File
'Fname must be FULL Path\Filename.zip
'DefPath must be valid Path you want to Unzip file TO

Dim FSO As Object
Dim oApp As Object

Set oApp = CreateObject("Shell.Application")
oApp.Namespace(DefPath).CopyHere oApp.Namespace(Fname).items

On Error Resume Next
Set FSO = CreateObject("scripting.filesystemobject")
FSO.deletefolder Environ("Temp") & "\Temporary Directory*", True

Set oApp = Nothing
Set FSO = Nothing
End Function
