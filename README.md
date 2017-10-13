# SoftWareEngineering
安否確認システム  
# クローン方法など  
以下のサイトを参考にしてください。不安なら澤田まで。  
<https://seleck.cc/630>
# 注意点
作業は各ブランチで行い、masterブランチでは作業をしないでください。  
ブランチの作成方法を下に書いておきます。  
branchの作成  
`git branch [branch名]`  
branchの切り替え  
`git checkout [branch名]`  
branchのプッシュ  
`git push -u origin [branch名]`  
各ブランチの作業をmasterブランチに反映させたい場合はPull Requestをおこなってください.  
# masterブランチの変更を自分のブランチに反映させる
　　　　git checkout [自分のブランチ名]  
　　　　git checkout master  
　　　　git pull  
　　　　git checkout [自分のブランチ名]  
　　　　git merge master  
# メンバー
永島康広
