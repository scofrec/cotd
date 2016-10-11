piVersion: v1
kind: BuildConfig
metadata:
  name: cotdpipeline
  labels:
    name: cotdpipeline
  annotations:
    pipeline.alpha.openshift.io/uses: '[{"name": "testphp", "namespace": "", "kind": "DeploymentConfig"}]'
spec:
  triggers:
    -
      type: GitHub
      github:
        secret: secret101
    -
      type: Generic
      generic:
        secret: secret101
  runPolicy: Serial
  source:
    type: None
  strategy:
    type: JenkinsPipeline
    jenkinsPipelineStrategy:
      jenkinsfile: "node('maven') {\nstage '==>Build'\nopenshiftBuild(buildConfig: 'testphp', showBuildLogs: 'true')\nstage '==>Deploy'\nopenshiftDeploy(deploymentConfig: 'testphp')\nopenshiftScale(deploymentConfig: 'testphp',replicaCount: '2')\n}"
  output:
  resources:
  postCommit:

